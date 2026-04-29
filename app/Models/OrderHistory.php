<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'role',
        'previous_status', 'new_status', 'remarks'
    ];

    // Relation sa order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relation sa user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
