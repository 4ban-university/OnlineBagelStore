<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Resources\ProductText as ProductTextResource;
use App\ProductText;
use Illuminate\Http\Request;

class ProductTextController extends Controller
{
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
}
