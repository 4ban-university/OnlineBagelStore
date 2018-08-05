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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
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
        $order = new Order;
        $order->customer    = $request->input('customer');
        $order->promotion   = $request->input('promotion');
        $order->price       = $request->input('price');
        $order->delivery_address    = $request->input('delivery_address');
        $order->payment_option      = $request->input('payment_option');
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
        $order = Order::findOrFail($id);
        $order->items = $order->items;
        foreach ($order->items as $item){
            $item->toppings = $item->toppings;
        }

        return new OrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $order = Order::findOrFail($id);
//        $order->title = $request->input('title');
//        $order->calories = $request->input('calories');
//        $order->description = $request->input('description');
//        $order->price = $request->input('price');
//        $order->image = $request->input('image');
//
//        if($order->save()) {
//            return new OrderResource($order);
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order->delete()) {
            return new OrderResource($order);
        }
    }
}
