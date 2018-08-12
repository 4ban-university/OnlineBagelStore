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
}
