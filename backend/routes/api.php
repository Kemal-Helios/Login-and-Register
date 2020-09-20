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

/*############################## START AUTHENTICATION USER #################################*/

Route::group(['prefix' => '/auth', ['middleware'=>'throttle:20,5']], function () {
    Route::group(['namespace' => 'Api\Auth'], function () {
        Route::post('/register', 'RegisterController@register'); //New user registration with fixed options
        Route::post('/login', 'LoginController@login');
    });
});


/*############################## END AUTHENTICATION USERS #################################*/

/*############################## START Dashboard  #################################*/
Route::group(['middleware'=> ['jwt.auth', 'can:administration']], function () {
    Route::group(['namespace' => 'Api\Dashboard\Users'], function () {
        Route::get('/admin-panel', 'usersController@homePage');
        Route::post('/add/user', 'addController@register');//Only an admin can add the user with options
        Route::get('/users', 'usersController@store');
        Route::post('/update/user/{userId}', 'usersController@update');
        Route::delete('/delete/user/{userId}', 'usersController@destroy')->name('company.destroy');

        Route::get('/logout', 'usersController@logout');
    });
});



/*############################## END Dashboard #################################*/

