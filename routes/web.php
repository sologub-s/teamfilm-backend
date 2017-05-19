<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('swagger', 'SwaggerController@index');

/**
 * API V1
 */
Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'user'], function () {

        // GET /user/{id}
        Route::get('{id}', 'UserController@get')
            ->where('id', '^[a-z0-9]{24}$');

        // POST /user
        Route::post('', 'UserController@post');

        // PATCH /user/{id}
        Route::patch('{id}', 'UserController@patch')
            ->where('id', '^[a-z0-9]{24}$');

        // DELETE /user/{id}
        Route::delete('{id}', 'UserController@delete')
            ->where('id', '^[a-z0-9]{24}$');

        // GET /user/{id}/avatar
        Route::get('{id}/avatar', 'UserController@getAvatar')
            ->where('id', '^[a-z0-9]{24}$');

        // POST /user/{id}/avatar
        Route::post('{id}/avatar', 'UserController@postAvatar')
            ->where('id', '^[a-z0-9]{24}$');

        // DELETE /user/{id}/avatar
        Route::delete('{id}/avatar', 'UserController@deleteAvatar')
            ->where('id', '^[a-z0-9]{24}$');
    });

    Route::group(['prefix' => 'auth'], function () {

        // POST /auth/login
        Route::post('login', 'AuthController@postLogin');

        // POST /auth/logout
        Route::post('logout', 'AuthController@postLogout');
    });
});

/**
 * Misc
 */

Route::group(['middleware' => 'authorization'], function () {



});