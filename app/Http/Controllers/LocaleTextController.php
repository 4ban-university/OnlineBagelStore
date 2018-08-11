<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Resources\LocaleText as LocaleTextResource;
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
        return LocaleTextResource::collection($productTexts);
    }
}
