<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Cart;
use App\Models\Order;

class PaypalController extends Controller
{
    public function payment()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $cartItems = Cart::where('user_id', auth()->user()->id)
                        ->where('order_id', null)
                        ->where('is_checked', 1)
                        ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $items = [];

        foreach ($cartItems as $cart) {
            $price = floatval($cart->price);
            $qty   = intval($cart->quantity);
            $total += $price * $qty;

            $items[] = [
                'name'        => $cart->product->title ?? 'Product',
                'unit_amount' => [
                    'currency_code' => 'PHP',
                    'value'         => number_format($price, 2, '.', ''),
                ],
                'quantity' => (string) $qty,
            ];
        }

        $coupon_discount = 0;
        if (session('coupon')) {
            $coupon_discount = session('coupon')['value'];
            $total -= $coupon_discount;
        }

        $total = max(0, $total);

        session(['paypal_cart_ids'  => $cartItems->pluck('id')->toArray()]);
        session(['paypal_total'     => $total]);
        session(['paypal_sub_total' => $cartItems->sum('amount')]);
        session(['paypal_coupon'    => $coupon_discount]);
        session(['paypal_quantity'  => $cartItems->sum('quantity')]);

        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'PHP',
                        'value'         => number_format($total, 2, '.', ''),
                        'breakdown'     => [
                            'item_total' => [
                                'currency_code' => 'PHP',
                                'value'         => number_format($total, 2, '.', ''),
                            ],
                        ],
                    ],
                    'items' => $items,
                ],
            ],
        ]);

        if (isset($order['links'])) {
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return back()->with('error', 'Something went wrong with PayPal. Please try again.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $paypalToken = $request->query('token');
        $response    = $provider->capturePaymentOrder($paypalToken);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $user      = auth()->user();
            $cartIds   = session('paypal_cart_ids', []);
            $cartItems = Cart::whereIn('id', $cartIds)->get();

            // Get PayPal transaction ID from response
            $transactionId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? $paypalToken;

            // Create one Order record per cart item
            foreach ($cartItems as $cart) {
                Order::create([
                    'order_number'      => 'ORD-' . strtoupper(uniqid()),
                    'user_id'           => $user->id,
                    'name'              => $user->name,
                    'email'             => $user->email,
                    'phone'             => $user->contact_number ?? '',
                    'address'           => $user->address ?? '',
                    'post_code'         => $user->postal_code ?? '',
                    'sub_total'         => $cart->price * $cart->quantity,
                    'coupon'            => 0,
                    'total_amount'      => $cart->price * $cart->quantity,
                    'quantity'          => $cart->quantity,
                    'shipping_id'       => 1,
                    'payment_method'    => 'paypal',
                    'payment_status'    => 'paid',
                    'payment_online_reference' => $transactionId,
                    'status'            => 'new',
                ]);

                // Reduce product stock
                if ($cart->product) {
                    $cart->product->decrement('stock', $cart->quantity);
                }
            }

            // Delete cart items
            Cart::whereIn('id', $cartIds)->delete();

            // Clear session
            session()->forget([
                'paypal_cart_ids',
                'paypal_total',
                'paypal_sub_total',
                'paypal_coupon',
                'paypal_quantity',
                'coupon',
            ]);

            return redirect()->route('home')
                ->with('success', 'Payment successful! Your order has been placed.');
        }

        return redirect()->route('payment.cancel')->with('error', 'Payment could not be completed.');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}