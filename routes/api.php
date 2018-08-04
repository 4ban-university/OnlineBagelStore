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

// Bagels API

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
