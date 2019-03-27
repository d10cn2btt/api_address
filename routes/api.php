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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => ['api', 'auth.jwt']], function () {
        Route::get('/me', 'UserController@getCurrentUser')->name('api.me.index');
        Route::put('/me', 'UserController@updateProfile')->name('api.me.update');
    });
});
