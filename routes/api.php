<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//注册用户
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');


Route::group(['middleware' => 'auth:api'], function() {
    Route::get('articles', 'StatusesApiController@index');
    Route::get('articles/{article}', 'StatusesApiController@show');
    Route::post('articles', 'StatusesApiController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');
});
