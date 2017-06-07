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
            'user' => UserMapper::execute(UserService::get($id), $this->getUser()->id == $id ? 'api_extended' : 'api')->toArray(),
        ]);

    }

    /**
     * @param String $field
     * @param String $value
     * @return Response
     */
    public function getByField(String $field, String $value)
    {

        return $this->response([
            'user' => UserMapper::execute($foundUser = UserService::getByField($field, $value), $this->getUser()->id == $foundUser->id ? 'api_extended' : 'api')->toArray(),
        ]);

    }

    /**
     * @return Response
     */
    public function post ()
    {
        return $this->response([
            'user' => UserMapper::execute(UserService::register(new \App\Models\User($this->getJsonParam('user'))), 'api_extended')->toArray()
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function patch(String $id)
    {
        if ($this->getUser()->id != $id) {
            throw new \App\Components\Api\Exception('', 403);
        }
        return $this->response([
            'user' => UserMapper::execute(UserService::update($id, $this->getJsonParam('user')), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function delete(String $id)
    {
        if ($this->getUser()->id != $id) {
            throw new \App\Components\Api\Exception('', 403);
        }
        UserService::delete($id);
        return $this->response();
    }

    /**
     * @param String $activation_token
     * @return Response
     */
    public function postActivate (String $activation_token) {
        return $this->response([
            'user' => UserMapper::execute(UserService::activateByToken($activation_token), 'api_extended')->toArray(),
        ]);
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
        if ($this->getUser()->id != $id) {
            throw new \App\Components\Api\Exception('', 403);
        }
        return $this->response([
            'avatar' => UserService::setAvatar($id)
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function deleteAvatar (String $id) {
        if ($this->getUser()->id != $id) {
            throw new \App\Components\Api\Exception('', 403);
        }
        UserService::deleteAvatar($id);
        return $this->response();
    }

    /**
     * @param String $id
     * @return Response
     */
    public function postCrop (String $id) {
        if ($this->getUser()->id != $id) {
            throw new \App\Components\Api\Exception('', 403);
        }
        return $this->response([
            'avatar' => UserService::cropAvatar($id, (int) $this->getJsonParam('crop.x'), (int) $this->getJsonParam('crop.y'), (int) $this->getJsonParam('crop.w'), (int) $this->getJsonParam('crop.h'))
        ]);
    }

    /**
     * @return Response
     */
    public function postLogin ()
    {
        return $this->response(['login' => UserService::login($this->getJsonParam('login.email'), $this->getJsonParam('login.password'), $this->getJsonParam('login.access_token_expire_at'))]);

    }

    /**
     * @return Response
     */
    public function postLogout ()
    {
        UserService::logout($this->getJsonParam('logout.access_token'));
        return $this->response();

    }

}
