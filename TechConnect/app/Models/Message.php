<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['name', 'message', 'email', 'phone', 'read_at', 'subject'];
}
