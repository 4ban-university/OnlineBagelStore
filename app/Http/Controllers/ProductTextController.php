<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Resources\ProductText as ProductTextResource;
use App\ProductText;
use Illuminate\Http\Request;

class ProductTextController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTexts = ProductText::all();
        return ProductTextResource::collection($productTexts);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productText = new ProductText();
        $productText->locale = $request->input('locale');
        $productText->product_type = $request->input('product_type');
        $productText->product_id = $request->input('product_id');
        $productText->type = $request->input('type');
        $productText->text = $request->input('text');

        if ($productText->save()) {
            return new ProductTextResource($productText);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productText = ProductText::FindOrFail($id);
        return new ProductTextResource($productText);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productText = ProductText::findOrFail($id);
        $productText->title = $request->input('title');
        $productText->calories = $request->input('calories');
        $productText->description = $request->input('description');
        $productText->allergyfree = $request->input('allergyfree');

        if ($productText->save()) {
            return new ProductTextResource($productText);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productText = ProductText::findOrFail($id);
        if ($productText->delete()) {
            return new ProductTextResource($productText);
        }
    }
}
