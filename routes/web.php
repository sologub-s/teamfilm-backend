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

Route::group(['prefix' => 'v1'], function () {
    /**
     * /user(s)
     */
    Route::get('user/{id}', 'UserController@get')
        ->where('id', '^[a-z0-9]{24}$');

    Route::post('users', 'UserController@post');

    Route::patch('user/{id}', 'UserController@patch')
        ->where('id', '^[a-z0-9]{24}$');

    Route::delete('user/{id}', 'UserController@delete')
        ->where('id', '^[a-z0-9]{24}$');

    Route::post('user/{id}/avatar', 'UserController@postAvatar')
        ->where('id', '^[a-z0-9]{24}$');

    Route::delete('user/{id}/avatar', 'UserController@deleteAvatar')
        ->where('id', '^[a-z0-9]{24}$');
});

/**
 * Misc
 */

Route::group(['middleware' => 'authorization'], function () {



});