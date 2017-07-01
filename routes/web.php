<?php

Route::post('user/register', 'AuthController@create');
Route::post('user/login', 'AuthController@login');

Route::middleware('jwt-auth')->group(function() {
    Route::get('user/home', 'UserController@home');
    Route::post('user/settings', 'UserController@update');

    Route::get('user/passwords', 'PasswordController@all');
    Route::delete('user/password/{passwordObject}', 'PasswordController@delete');
    Route::put('user/password/{passwordObject}', 'PasswordController@update');
    Route::post('user/password', 'PasswordController@store');
});


Route::get('{anything}', function () {
    return view('app');
})->where('anything', '.*');
