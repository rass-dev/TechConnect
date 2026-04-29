<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Models\OrderHistory;

use App\Notifications\StatusNotification;
use PDF;
use Helper;


class MyOrdersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('frontend.pages.orders.my-orders', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Get selected cart items only
        $selectedIds = $request->input('cart_ids'); // from hidden input sa checkout form

        if ($selectedIds) {
            $idsArray = explode(',', $selectedIds);

            $cartItems = Cart::where('user_id', $user->id)
                ->whereNull('order_id')
                ->whereIn('id', $idsArray)
                ->get();
        } else {
            $cartItems = collect(); // walang napili
        }

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty or no products selected!');
            return back();
        }

        // --- shipping info
        $shipping = Shipping::find($request->shipping_id);
        $shippingPrice = $shipping->price ?? 0;

        // --- create order
        $order = new Order();
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->user_id = $user->id;
        $order->name = $user->name;
        $order->email = $user->email;
        $order->phone = $user->contact_number ?? '';
        $order->address = $user->address ?? '';
        $order->post_code = $user->postal_code ?? '';
        $order->shipping_id = $request->shipping_id;

        // --- calculate totals based on selected cart items
        $subtotal = $cartItems->sum('amount');
        $couponValue = session('coupon')['value'] ?? 0;
        $order->sub_total = $subtotal;
        $order->quantity = $cartItems->sum('quantity');
        $order->coupon = $couponValue;
        $order->total_amount = $subtotal - $couponValue + $shippingPrice;

        // --- payment info
        $order->payment_method = $request->payment_method === 'paypal' ? 'paypal' : 'cod';
        $order->payment_status = $order->payment_method === 'paypal' ? 'paid' : 'Unpaid';

        // --- order status
        $order->status = 'new';
        $order->save();

        // --- link cart items to order
        foreach ($cartItems as $cart) {
            $cart->order_id = $order->id;
            $cart->shipping_id = $order->shipping_id;
            $cart->save();
        }

        // --- notify admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $details = [
                'title' => 'New order created',
                'actionURL' => route('order.show', $order->id),
                'fas' => 'fa-file-alt'
            ];
            Notification::send($admin, new StatusNotification($details));
        }

        // --- clear sessions if COD
        if ($order->payment_method === 'cod') {
            session()->forget('cart');
            session()->forget('coupon');
            session()->flash('success', 'Your order has been placed successfully!');
            return redirect()->route('home');
        }

        return redirect()->route('payment')->with(['id' => $order->id]);
    }


    public function destroyItem($id)
    {
        $item = Cart::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Cart item deleted successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Load order with related items & shipping
        $order = Order::with(['items.product', 'shipping'])->findOrFail($id);

        // Admin view
        if (Auth::check() && (Auth::user()->role ?? '') === 'admin') {
            return view('backend.order.show', compact('order'));
        }

        // Frontend: ensure the user owns the order
        if (Auth::check() && $order->user_id == Auth::id()) {
            // Pass the order and status for dynamic rendering
            return view('frontend.pages.orders.show-order', [
                'order' => $order,
                'status' => $order->status
            ]);
        }

        abort(403, 'Unauthorized action.');
    }

    // Orders with "new" or "process" status
    public function toProcess()
    {
        $orders = Order::where('user_id', auth()->id())
            ->whereIn('status', ['new', 'process'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.orders.to-process', compact('orders'));
    }

    // Orders with "on_the_way" status
    public function toShip()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'on_the_way')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.orders.to-ship', compact('orders'));
    }

    // Orders that are "delivered" but not yet completed
    public function toReceive()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.orders.to-receive', compact('orders'));
    }

    // Orders "completed"
    public function completeDelivered()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.orders.complete-delivered', compact('orders'));
    }

        // Orders "complete delivery" confirmation
public function confirmDelivery($id)
{
    $order = Order::findOrFail($id);

    if ($order->status === 'delivered') {
        $order->status = 'completed';
        $order->save();

        return redirect()->back()->with('success', 'Order delivery confirmed!');
    }

    return redirect()->back()->with('error', 'Cannot confirm delivery for this order.');
}


    // Orders "cancelled"
    public function cancelled()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'cancel')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.orders.cancelled', compact('orders'));
    }
    
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Only allow cancelling if status is new or process
        if (in_array($order->status, ['new', 'process'])) {
            $order->status = 'cancel';
            $order->save();
            return redirect()->back()->with('success', 'Order has been cancelled.');
        }

        return redirect()->back()->with('error', 'This order cannot be cancelled.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function history($id)
    {
        // Kunin lahat ng history ng order kasama user info
        $histories = \App\Models\OrderHistory::where('order_id', $id)
            ->with('user') // optional kung gusto mo makuha info ng user
            ->orderBy('created_at', 'desc')
            ->get();

        // Return view partial lang (di buong layout)
        return view('backend.order.partials.history', compact('histories'));
    }




    public function update(Request $request, $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        $this->validate($request, [
            'status' => 'required|in:new,process,on_the_way,delivered,completed,cancel'
        ]);

        $oldStatus = $order->status; // dati
        $newStatus = $request->status; // bago

        // ✅ Bawas stock kapag naging completed
        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }
        }

        // ✅ Ibalik stock kapag naging cancel (pero hindi pa completed dati)
        if ($oldStatus !== 'cancel' && $newStatus === 'cancel') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
        }

        $order->status = $newStatus;
        $order->save();

        // ✅ Generate automatic remarks
        $remarks = "Status changed from {$oldStatus} to {$newStatus} by " . (Auth::user()->name ?? 'system');

        // ✅ Log sa order_histories
        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role ?? 'user',
            'previous_status' => $oldStatus,
            'new_status' => $newStatus,
            'remarks' => $remarks,
        ]);

        request()->session()->flash('success', 'Successfully updated order status!');
        return redirect()->route('order.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('success', 'Your order has been placed. please wait.');
                return redirect()->route('home');

            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Your order is under processing please wait.');
                return redirect()->route('home');

            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Your order is successfully delivered.');
                return redirect()->route('home');

            } else {
                request()->session()->flash('error', 'Your order canceled. please try again');
                return redirect()->route('home');

            }
        } else {
            request()->session()->flash('error', 'Invalid order numer please try again');
            return back();
        }
    }

    public function pdf($id)
    {
        // Load the order with related items and shipping info
        $order = Order::with('items.product', 'shipping')->findOrFail($id);

        // Generate PDF using the Blade view
        $pdf = PDF::loadView('backend.order.pdf', compact('order'));

        // Define filename
        $fileName = 'Invoice_' . $order->order_number . '.pdf';

        // Instead of saving to server Downloads folder, we return download directly
        return $pdf->download($fileName);
    }

    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;

        $orders = Order::with('items')
            ->whereYear('created_at', $year)
            ->where('status', 'completed') // income counted pag completed na
            ->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        foreach ($orders as $month => $orderCollection) {
            foreach ($orderCollection as $order) {
                $amount = $order->items->sum('amount'); // ensure may 'amount' column sa Cart
                $m = intval($month);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i]))
                ? number_format((float) ($result[$i]), 2, '.', '')
                : 0.0;
        }

        return $data;
    }

    public function checkoutPage()
    {
        $user = auth()->user();

        // Get only items that are checked (is_checked = 1)
        $cartItems = Cart::where('user_id', $user->id)
            ->whereNull('order_id')
            ->where('is_checked', 1)
            ->with('product')
            ->get();

        $couponValue = session('coupon')['value'] ?? 0;
        $subtotal = $cartItems->sum('amount');
        $total = $subtotal - $couponValue;

        return view('frontend.pages.checkout', compact('cartItems', 'subtotal', 'couponValue', 'total', 'user'));
    }




}
