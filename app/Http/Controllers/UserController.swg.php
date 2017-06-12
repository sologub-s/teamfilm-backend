<?php

    /**
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
    //public function get(String $id);

    /**
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
    //public function getByField(String $field, String $value);

    /**
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
    //public function post();

    /**
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
    //public function patch(String $id);

    /**
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
    //public function delete(String $id);

    /**
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
    //public function postActivate (String $activation_token);

    /**
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
    //public function getAvatar(String $id);

    /**
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
     *         property="avatar",
     *         ref="#/definitions/Avatar"
     *       ),
     *     )
     *   )
     * )
     *
     */
    //public function postAvatar (String $id);

    /**
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
    //public function deleteAvatar (String $id);

    /**
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
    //public function postCrop (String $id);

    /**
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
    //public function postLogin();

    /**
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
    //public function postLogout();


