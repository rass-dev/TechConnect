<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'sub_total',
        'quantity',
        'delivery_charge',
        'status',
        'total_amount',
        'email',
        'phone',
        'address',
        'post_code',
        'payment_method',
        'payment_status',
        'shipping_id',
        'coupon'
    ];

    /**
     * Relationship: Get all cart items for this order
     * Loads the associated product automatically
     */
    public function items()
    {
        return $this->hasMany(Cart::class, 'order_id', 'id')->with('product');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }



    /**
     * Relationship: Shipping info for this order
     */
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    /**
     * Relationship: User who placed this order
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Fetch a specific order with its cart items and their products
     */
    public static function getAllOrder($id)
    {
        return self::with('items.product', 'shipping', 'user')->find($id);
    }

    /**
     * Count all orders
     */
    public static function countActiveOrder()
    {
        return self::count();
    }
}
