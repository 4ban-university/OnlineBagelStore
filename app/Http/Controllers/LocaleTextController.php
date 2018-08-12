<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\ProductText;


class LocaleTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale)
    {
        $productTexts = ProductText::where('locale', $locale)->get();
        $return = [];
        foreach($productTexts as $productText) {
            $return[$productText->product_type . "." . $productText->product_id . "." . $productText->type] = $productText->text;
        }
        return response()->json($return);
    }
}
