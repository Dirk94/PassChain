<?php

Route::post('user/register', 'AuthController@create');
Route::post('user/login', 'AuthController@login');

Route::middleware('jwt-auth')->group(function() {
    Route::get('user/home', 'UserController@home');
    Route::post('user/settings', 'UserController@update');
});


Route::get('{anything}', function () {
    return view('app');
})->where('anything', '.*');
