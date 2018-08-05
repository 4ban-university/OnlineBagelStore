<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemTopping extends Model
{
    protected $fillable = ['order_item_id','topping_id', 'amount'];
}
