<?php

Route::group(['prefix' => 'admin', 'middleware' => 'default.guard'], function () {
    Voyager::routes();
});

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
