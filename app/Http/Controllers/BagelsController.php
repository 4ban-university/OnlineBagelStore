<?php

namespace App\Http\Controllers;

use App\Bagel;
use App\Http\Requests;
use App\Http\Resources\Bagel as BagelResource;
use Illuminate\Http\Request;

class BagelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bagels = Bagel::all();
        return BagelResource::collection($bagels);
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
        $bagel = new Bagel;
        $bagel->title = $request->input('title');
        $bagel->calories = $request->input('calories');
        $bagel->description = $request->input('description');
        $bagel->price = $request->input('price');
        $bagel->image = $request->input('image');

        if($bagel->save()) {
            return new BagelResource($bagel);
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
        $bagel = Bagel::findOrFail($id);
        return new BagelResource($bagel);
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
        $bagel = Bagel::findOrFail($id);
        $bagel->title = $request->input('title');
        $bagel->calories = $request->input('calories');
        $bagel->description = $request->input('description');
        $bagel->price = $request->input('price');
        $bagel->image = $request->input('image');

        if($bagel->save()) {
            return new BagelResource($bagel);
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
        $bagel = Bagel::findOrFail($id);
        if($bagel->delete()) {
            return new BegelResource($bagel);
        }
    }
}
