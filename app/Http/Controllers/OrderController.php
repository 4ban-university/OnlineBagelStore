<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Resources\Order as OrderResource;
use App\Order;
use App\OrderItem;
use App\OrderItemTopping;
use Illuminate\Http\Request;

class OrderController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->customer    = $request->input('customer');
        $order->price       = $request->input('price');
        $order->street_number = $request->input('street_number');
        $order->street_name   = $request->input('street_name');
        $order->apartment   = $request->input('apartment');
        $order->postcode    = $request->input('postcode');
        $order->province    = $request->input('province');
        $order->save();

        foreach ($request->input('items') as $item_input){
            $item = new OrderItem($item_input);
            $item->order_id = $order->id;
            $item->save();

            foreach ($item_input['toppings'] as $topping_input) {
                $topping = new OrderItemTopping($topping_input);
                $topping->order_item_id = $item->id;
                $topping->save();
            }
        }
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['items', 'items.product', 'items.toppings', 'items.toppings.topping'])->findOrFail($id);

        return new OrderResource($order);
    }
}
