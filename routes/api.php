<?php

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

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::middleware(['api'])->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::apiResource('contact', 'ContactController');
    });
});
