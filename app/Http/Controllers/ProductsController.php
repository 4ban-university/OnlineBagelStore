<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bagels = Product::all();
        return ProductResource::collection($bagels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->title = $request->input('title');
        $product->calories = $request->input('calories');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->image = $request->input('image');
        $product->type = $request->input('type');

        if($product->save()) {
            return new ProductResource($product);
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
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }
}
