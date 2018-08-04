<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Resources\Topping as ToppingResource;
use App\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toppings = Topping::all();
        return ToppingResource::collection($toppings);
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
        $topping = new Topping();
        $topping->title = $request->input('title');
        $topping->calories = $request->input('calories');
        $topping->description = $request->input('description');
        $topping->allergyfree = $request->input('allergyfree');

        if($topping->save()) {
            return new ToppingResource($topping);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topping = Topping::FindOrFail($id);
        return new ToppingResource($topping);
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
        $topping = Topping::findOrFail($id);
        $topping->title = $request->input('title');
        $topping->calories = $request->input('calories');
        $topping->description = $request->input('description');
        $topping->allergyfree = $request->input('allergyfree');

        if($topping->save()) {
            return new ToppingResource($topping);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topping = Topping::findOrFail($id);
        if($topping->delete()) {
            return new ToppingResource($topping);
        }
    }
}
