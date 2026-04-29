<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = auth()->user();

        // Get cart items for this user that are checked
        $cartItems = Cart::where('user_id', $user->id)
            ->whereNull('order_id')
            ->where('is_checked', 1)
            ->with('product')
            ->get();

        // Calculate totals
        $subtotal = $cartItems->sum('amount');
        $couponValue = session('coupon')['value'] ?? 0;
        $total = $subtotal - $couponValue;

        // Pass variables to view
        return view('frontend.pages.checkout', compact(
            'cartItems',
            'subtotal',
            'couponValue',
            'total',
            'user'
        ));
    }
}
