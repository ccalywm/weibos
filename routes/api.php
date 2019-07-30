<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//注册用户
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');


Route::group(['middleware' => 'auth:api'], function() {
    Route::get('statuses', 'StatusesApiController@index');
    Route::get('statuses/{name}', 'StatusesApiController@show');
    Route::post('statuses', 'StatusesApiController@store');
    Route::put('statuses/{name}', 'StatusesApiController@update');
    Route::delete('statuses/{name}', 'StatusesApiController@delete');
});
