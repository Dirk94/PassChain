<?php

Route::post('user/register', 'AuthController@create');
Route::post('user/login', 'AuthController@login');

Route::middleware('jwt-auth')->group(function() {
    Route::get('user/home', 'UserController@home')->middleware('jwt-auth');
});


Route::get('{anything}', function () {
    return view('app');
})->where('anything', '.*');
