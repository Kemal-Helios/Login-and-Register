<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '/auth', ['middleware'=>'throttle:20,5']], function () {
    Route::group(['namespace' => 'Api\Auth'], function () {
        Route::post('/register', 'RegisterController@register');
        Route::post('/login', 'LoginController@login');
        
    });
});
Route::group(['middleware'=>'jwt.auth'], function () {
    Route::group(['namespace' => 'Api'], function () {
        Route::get('/my', 'MyController@index');
        Route::get('/auth/logout', 'MyController@logout');
    });
});