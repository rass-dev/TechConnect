<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserOrderController extends Controller
{
    // ✅ To Process (new + process)
    public function toProcess() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                       ->whereIn('status', ['new', 'process'])
                       ->get();

        return view('frontend.pages.orders.to-process', compact('orders'));
    }

    // ✅ To Ship / On the Way
    public function toShip() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                       ->where('status', 'on_the_way')
                       ->get();

        return view('frontend.pages.orders.to-ship', compact('orders'));
    }

    // ✅ To Receive
    public function toReceive() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                       ->where('status', 'delivered')
                       ->get();

        return view('frontend.pages.orders.to-receive', compact('orders'));
    }

    // ✅ Complete Delivered
    public function completeDelivered() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                       ->where('status', 'completed')
                       ->get();

        return view('frontend.pages.orders.complete-delivered', compact('orders'));
    }

    // ✅ Cancelled
    public function cancelled() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                       ->where('status', 'cancel')
                       ->get();

        return view('frontend.pages.orders.cancelled', compact('orders'));
    }
}

