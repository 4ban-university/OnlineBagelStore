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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

// APIs

// Products API

// List Products
Route::get('products', 'ProductsController@index');

// List Bagel
Route::get('product/{id}', 'ProductsController@show');

// Create Bagel
Route::post('product', 'ProductsController@store');

// Edit Bagel
Route::put('product/{id}', 'ProductsController@update');

// Delete Bagel
Route::delete('product/{id}', 'ProductsController@destroy');

// Toppings API

// List Toppings
Route::get('toppings', 'ToppingController@index');

// List Topping
Route::get('topping/{id}', 'ToppingController@show');

// Create Topping
Route::post('topping', 'ToppingController@store');

// Edit Topping
Route::put('topping/{id}', 'ToppingController@update');

// Delete Topping
Route::delete('topping/{id}', 'ToppingController@destroy');


// Orders API

// List Orders
Route::get('orders', 'OrderController@index');

// List Order
Route::get('order/{id}', 'OrderController@show');

// Create Order
Route::post('order', 'OrderController@store');

// Edit Order
Route::put('order/{id}', 'OrderController@update');

// Delete Order
Route::delete('order/{id}', 'OrderController@destroy');

// Check coupon existence
Route::get('coupon/{name}', 'CouponController@isValid');