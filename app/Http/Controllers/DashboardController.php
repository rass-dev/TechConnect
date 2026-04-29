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


class DashboardController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
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
    $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail(); // ensures user only sees their own orders

    return view('frontend.pages.order-details', compact('order'));
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
        $order = Order::with('items.product', 'shipping')->findOrFail($id);

        $pdf = Pdf::loadView('backend.order.pdf', compact('order'));

        $downloadsPath = getenv('USERPROFILE') . '\Downloads\\';
        if (!file_exists($downloadsPath)) {
            mkdir($downloadsPath, 0755, true);
        }

        $fileName = 'Invoice_' . $order->order_number . '.pdf';
        $fullPath = $downloadsPath . $fileName;

        $pdf->save($fullPath);

        // balik sa previous page + flash success message
        return redirect()->back()->with('success', "PDF saved to Downloads! ({$fileName})");
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


// For admin dashboard: Product-wise order income - MALINAO
public function productOrderIncome(Request $request)
{
    $type = $request->input('type', 'monthly'); // daily, monthly, yearly
    $product = $request->input('product', null);

    $orders = \App\Models\Order::where('status', 'completed')->with('items.product')->get();

    $data = [];

    if ($type === 'yearly') {
        foreach ($orders as $order) {
            $year = $order->created_at->format('Y');
            $total = 0;
            foreach ($order->items as $item) {
                if ($product && $item->product && $item->product->title !== $product) continue;
                $total += $item->amount;
            }
            if (!isset($data[$year])) $data[$year] = 0;
            $data[$year] += $total;
        }
    } elseif ($type === 'daily') {
        foreach ($orders as $order) {
            $day = $order->created_at->format('Y-m-d');
            $total = 0;
            foreach ($order->items as $item) {
                if ($product && $item->product && $item->product->title !== $product) continue;
                $total += $item->amount;
            }
            if (!isset($data[$day])) $data[$day] = 0;
            $data[$day] += $total;
        }
    } else {
        // Monthly
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $months[$monthName] = 0;
        }
        foreach ($orders as $order) {
            $monthName = $order->created_at->format('F');
            $total = 0;
            foreach ($order->items as $item) {
                if ($product && $item->product && $item->product->title !== $product) continue;
                $total += $item->amount;
            }
            $months[$monthName] += $total;
        }
        $data = $months;
    }

    return response()->json($data);
}


}
