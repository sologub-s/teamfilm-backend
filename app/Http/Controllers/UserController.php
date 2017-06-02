<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as Response;
use App\Components\Api\JsonController;
use App\Mappers\UserMapper;
use App\Services\UserService;

class UserController extends JsonController
{

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Get(path="/user/{id}",
     *   tags={"user"},
     *   summary="Return User by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@get",
     *   security={{"X-Auth":{}}},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/User"
     *       ),
     *     )
     *   )
     * )
     */
    public function get(String $id)
    {

        return $this->response([
            'user' => UserMapper::execute(UserService::get($id), 'api')->toArray(),
        ]);

    }

    /**
     * @param String $field
     * @param String $value
     * @return Response
     *
     * @SWG\Get(path="/user/by/{field}/{value}",
     *   tags={"user"},
     *   summary="Return User by field's value",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@getByField",
     *   security={{"X-Auth":{}}},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="field",
     *     type="string",
     *     in="path",
     *     description="field name, ENUM(id, email, nickname, activation_token)",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     name="value",
     *     type="string",
     *     in="path",
     *     description="field value",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/User"
     *       ),
     *     )
     *   )
     * )
     *
     */
    public function getByField(String $field, String $value)
    {

        return $this->response([
            'user' => UserMapper::execute(UserService::getByField($field, $value), 'api')->toArray(),
        ]);

    }

    /**
     * @return Response
     *
     * @SWG\Post(path="/user",
     *   tags={"user"},
     *   summary="Register User and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@post",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="user",
     *     type="string",
     *     in="body",
     *     description="User model",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="user", ref="#/definitions/User"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/User"
     *       ),
     *     )
     *   )
     * )
     *
     */
    public function post ()
    {
        return $this->response([
            'user' => UserMapper::execute(UserService::register(new \App\Models\User($this->getJsonParam('user'))), 'api')->toArray()
        ]);
    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Patch(path="/user",
     *   tags={"user"},
     *   summary="Change User and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@patch",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="user",
     *     type="string",
     *     in="body",
     *     description="A part of User model - any non-protected fields",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="user", ref="#/definitions/User"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/User"
     *       )
     *     )
     *   )
     * )
     *
     */
    public function patch(String $id)
    {
        return $this->response([
            'user' => UserMapper::execute(UserService::update($id, $this->getJsonParam('user')), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Delete(path="/user/{id}",
     *   tags={"user"},
     *   summary="Delete User by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@delete",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     *
     */
    public function delete(String $id)
    {
        UserService::delete($id);
        return $this->response();
    }

    /**
     * @param String $activation_token
     * @return Response
     *
     * @SWG\Post(path="/user/activate/{activation_token}",
     *   tags={"user"},
     *   summary="Activate User by activation_token",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@postActivate",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="activation_token",
     *     type="string",
     *     in="path",
     *     description="activation_token that was sent to email",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/User"
     *       )
     *     )
     *   )
     * )
     *
     */
    public function postActivate (String $activation_token) {
        return $this->response([
            'user' => UserMapper::execute(UserService::activateByToken($activation_token), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Get(path="/user/{id}/avatar",
     *   tags={"user","avatar"},
     *   summary="Return User's avatar by user id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@getAvatar",
     *   security={{"X-Auth":{}}},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="avatar",
     *         ref="#/definitions/Avatar"
     *       )
     *     )
     *   )
     * )
     *
     */
    public function getAvatar(String $id)
    {

        return $this->response([
            'avatar' => UserMapper::execute(UserService::get($id), 'api')->toArray()['avatar']
        ]);

    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Post(path="/user/avatar",
     *   tags={"user","avatar"},
     *   summary="Upload avatar",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@post",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="avatar[]",
     *     type="file",
     *     in="formData",
     *     description="User's avatar",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="user",
     *         ref="#/definitions/Avatar"
     *       ),
     *     )
     *   )
     * )
     *
     */
    public function postAvatar (String $id) {
        return $this->response([
            'avatar' => UserService::setAvatar($id)
        ]);
    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Delete(path="/user/{id}/avatar",
     *   tags={"user","avatar"},
     *   summary="Delete User's avatar by user id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@deleteAvatar",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     *
     */
    public function deleteAvatar (String $id) {
        UserService::deleteAvatar($id);
        return $this->response();
    }

    /**
     * @param String $id
     * @return Response
     *
     * @SWG\Post(path="/user/{id}/avatar/crop",
     *   tags={"user","avatar","crop"},
     *   summary="Crop User's avatar by user id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@postCrop",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     name="crop",
     *     type="string",
     *     in="body",
     *     description="Crop values",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="crop", ref="#/definitions/Crop"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     *
     */
    public function postCrop (String $id) {
        return $this->response([
            'avatar' => UserService::cropAvatar($id, (int) $this->getJsonParam('crop.x'), (int) $this->getJsonParam('crop.y'), (int) $this->getJsonParam('crop.w'), (int) $this->getJsonParam('crop.h'))
        ]);
    }

    /**
     * @return Response
     *
     * @SWG\Post(path="/user/{id}/login",
     *   tags={"user","login"},
     *   summary="User login",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@postLogin",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     name="login",
     *     type="string",
     *     in="body",
     *     description="Login values",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="login", ref="#/definitions/LogIn"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="login",
     *         ref="#/definitions/LogIn"
     *       ),
     *     )
     *   )
     * )
     */
    public function postLogin ()
    {
        return $this->response(['login' => UserService::login($this->getJsonParam('login.email'), $this->getJsonParam('login.password'), $this->getJsonParam('login.access_token_expire_at'))]);

    }

    /**
     * @return Response
     *
     * @SWG\Post(path="/user/{id}/logout",
     *   tags={"user","logout"},
     *   summary="User logout",
     *   description="Returns a map of status codes to quantities",
     *   operationId="UserController@postLogout",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="user id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     name="logout",
     *     type="string",
     *     in="body",
     *     description="Logout values",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="logout", ref="#/definitions/LogOut"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     */
    public function postLogout ()
    {
        UserService::logout($this->getJsonParam('logout.access_token'));
        return $this->response();

    }

}
