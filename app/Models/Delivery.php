<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'orders';
    protected $fillable = ['uid', 'user_id', 'user_info', 'delivery_info', 'products', 'total_price', 'status'];
}
