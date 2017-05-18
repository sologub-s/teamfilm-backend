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
     */
    public function get(String $id)
    {

        return $this->response([
            'user' => UserMapper::execute(UserService::get($id), 'api')->toArray()
        ]);

    }

    /**
     * @return Response
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
     */
    public function patch(String $id)
    {
        return $this->response([
            'user' => UserMapper::execute(UserService::update($id, $this->getJsonParam('user')), 'api')->toArray()
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function delete(String $id)
    {
        UserService::delete($id);
        return $this->response();
    }

    /**
     * @param String $id
     * @return Response
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
     */
    public function postAvatar (String $id) {
        return $this->response([
            'avatar' => UserService::setAvatar($id)
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function deleteAvatar (String $id) {
        UserService::deleteAvatar($id);
        return $this->response();
    }

}
