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

Route::get('swagger.json', 'SwaggerController@index');

/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="api.teamfilm.dev",
 *   basePath="/v1"
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="X-Auth",
 *   type="apiKey",
 *   in="header",
 *   name="X-Auth"
 * )
 */

/**
 * @SWG\Info(title="TeamFilm API", version="0.1")
 */
Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'user'], function () {

        Route::group(['middleware' => 'authorization'], function () {

            // GET /user/{id}
            Route::get('{id}', 'UserController@get')
                ->where('id', '^[a-z0-9]{24}$');

            // GET /user/by/{field}/{value}
            Route::get('by/{field}/{value}', 'UserController@getByField');

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

            // POST /user/{id}/avatar/crop
            Route::post('{id}/avatar/crop', 'UserController@postCrop')
                ->where('id', '^[a-z0-9]{24}$');

            // POST /user/logout
            Route::post('logout', 'UserController@postLogout');

        });

        // POST /user/login
        Route::post('login', 'UserController@postLogin');

        // POST /user
        Route::post('', 'UserController@post');

        // POST /user/activate/{activation_token}
        Route::post('activate/{activation_token}', 'UserController@postActivate');

    });

    Route::group(['prefix' => 'project', 'middleware' => 'authorization'], function () {

        // GET /project/{id}
        Route::get('{id}', 'ProjectController@get')
            ->where('id', '^[a-z0-9]{24}$');

        // GET /project/list
        Route::get('list', 'ProjectController@getList');

        // POST /project
        Route::post('', 'ProjectController@post');

        // PATCH /project/{id}
        Route::patch('{id}', 'ProjectController@patch')
            ->where('id', '^[a-z0-9]{24}$');

        // DELETE /project/{id}
        Route::delete('{id}', 'ProjectController@delete')
            ->where('id', '^[a-z0-9]{24}$');

        // GET /project/{id}/logo
        Route::get('{id}/logo', 'ProjectController@getLogo')
            ->where('id', '^[a-z0-9]{24}$');

        // POST /project/{id}/logo
        Route::post('{id}/logo', 'ProjectController@postLogo')
            ->where('id', '^[a-z0-9]{24}$');

        // DELETE /project/{id}/logo
        Route::delete('{id}/logo', 'ProjectController@deleteLogo')
            ->where('id', '^[a-z0-9]{24}$');

    });

    Route::group(['prefix' => 'position', 'middleware' => 'authorization'], function () {

        // GET /position/{id}
        Route::get('{id}', 'PositionController@get')
            ->where('id', '^[a-z0-9]{24}$');

        // GET /position/list
        Route::get('list', 'PositionController@getList');

        // POST /position
        Route::post('', 'PositionController@post');

        // PATCH /position/{id}
        Route::patch('{id}', 'PositionController@patch')
            ->where('id', '^[a-z0-9]{24}$');

        // DELETE /position/{id}
        Route::delete('{id}', 'PositionController@delete')
            ->where('id', '^[a-z0-9]{24}$');

    });

});