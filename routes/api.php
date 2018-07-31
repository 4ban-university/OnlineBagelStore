<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// List Bagels
Route::get('bagels', 'BagelsController@index');

// List Bagel
Route::get('bagel/{id}', 'BagelsController@show');

// Create Bagel
Route::post('bagel', 'BagelsController@store');

// Edit Bagel
Route::put('bagel/{id}', 'BagelsController@update');

// Delete Bagel
Route::delete('bagel/{id}', 'BagelsController@destroy');
