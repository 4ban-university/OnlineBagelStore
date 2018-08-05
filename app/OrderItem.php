<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['bagel_id', 'amount'];

    public function toppings()
    {
        return $this->hasMany('App\OrderItemTopping');
    }
}
