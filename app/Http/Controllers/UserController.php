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
            'user' => UserMapper::execute(UserService::get($id), 'api')->toArray(),
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
            'user' => UserMapper::execute(UserService::getByField($field, $value), 'api')->toArray(),
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
            'user' => UserMapper::execute(UserService::update($id, $this->getJsonParam('user')), 'api')->toArray(),
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
     * @param String $activation_token
     * @return Response
     */
    public function postActivate (String $activation_token) {
        return $this->response([
            'user' => UserMapper::execute(UserService::activateByToken($activation_token), 'api')->toArray(),
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

    /**
     * @param String $id
     * @return Response
     */
    public function cropAvatar (String $id) {
        return $this->response([
            'avatar' => UserService::cropAvatar($id, (int) $this->getJsonParam('crop.x'), (int) $this->getJsonParam('crop.y'), (int) $this->getJsonParam('crop.w'), (int) $this->getJsonParam('crop.h'))
        ]);
    }

    /**
     * @return Response
     */
    public function postLogin ()
    {
        if (FALSE === $result = UserService::login($this->getJsonParam('user.email'), $this->getJsonParam('user.password'), $this->getJsonParam('user.access_token_expire_at'))) {
            return $this->response([
                'loggedIn' => false,
            ]);
        }
        return $this->response(array_merge($result, [
            'loggedIn' => true,
        ]));

    }

    /**
     * @return Response
     */
    public function postLogout ()
    {
        return $this->response([
            'loggedOut' => UserService::logout($this->getJsonParam('user.access_token')),
        ]);

    }

}
