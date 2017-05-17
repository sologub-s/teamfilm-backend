<?php

namespace App\Http\Controllers;

use App\Components\Api\JsonController;
use App\Mappers\UserMapper;
use App\Services\UserService;

class UserController extends JsonController
{
    /**
     * @param String $id
     * @return mixed
     * @throws \App\Components\Api\Exception
     */
    public function get(String $id)
    {

        try {
            if (is_null($user = \App\Models\User::fetchOne(['id' => (string)$id]))) {
                throw new \App\Components\Api\Exception("User with id '".$id."' not found", 404);
            }
        } catch (\MongoDB\Driver\Exception\InvalidArgumentException $e) {
            throw new \App\Components\Api\Exception(null, 400);
        }

        UserService::register($user);

        return $this->response([
            'user' => $user->toArray(),
        ]);

    }

    /**
     * @return mixed
     * @throws \App\Components\Api\Exception
     */
    public function post ()
    {
        try {
            return $this->response([
                'user' => UserMapper::execute(UserService::register(new \App\Models\User($this->getJsonParam('user'))), 'api')->toArray()
            ]);
        } catch (\App\Exceptions\User\EmailAlreadyExistsException $e) {
            throw new \App\Components\Api\Exception("User with this email already exists", 500);
        } catch (\App\Exceptions\User\NicknameAlreadyExistsException $e) {
            throw new \App\Components\Api\Exception("User with this nickname already exists", 500);
        } catch (\App\Exceptions\User\InvalidEntityException $e) {
            throw new \App\Components\Api\Exception("User data validation failed: ".$e->getMessage(), 400);
        } catch (\MongoStar\Model\Driver\Exception\PropertyHasDifferentType $e) {
            throw new \App\Components\Api\Exception("User data validation failed: ".$e->getMessage(), 400);
        } catch (\App\Exceptions\User\CannotSendRegistrationEmailException $e) {
            throw new \App\Components\Api\Exception("Cannot send registration email", 500);
        } catch (\App\Exceptions\CannotSaveEntityException $e) {
            throw new \App\Components\Api\Exception("User cannot be saved", 500);
        }
    }

    /**
     * @param String $id
     * @return mixed
     * @throws \App\Components\Api\Exception
     */
    public function patch(String $id)
    {
        try {
            return $this->response([
                'user' => UserMapper::execute(UserService::update($id, $this->getJsonParam('user')), 'api')->toArray()
            ]);
        } catch (\App\Exceptions\EntityNotFoundException $e) {
            throw new \App\Components\Api\Exception("User not found", 404);
        } catch (\App\Exceptions\User\NicknameAlreadyExistsException $e) {
            throw new \App\Components\Api\Exception("User with this nickname already exists", 500);
        } catch (\App\Exceptions\User\InvalidEntityException $e) {
            throw new \App\Components\Api\Exception("User data validation failed: ".$e->getMessage(), 400);
        } catch (\MongoStar\Model\Driver\Exception\PropertyHasDifferentType $e) {
            throw new \App\Components\Api\Exception("User data validation failed: ".$e->getMessage(), 400);
        } catch (\App\Exceptions\CannotSaveEntityException $e) {
            throw new \App\Components\Api\Exception("User cannot be saved", 500);
        }

    }

    /**
     * @param String $id
     * @return mixed
     * @throws \App\Components\Api\Exception
     */
    public function delete(String $id)
    {
        try {
            UserService::delete($id);
        } catch (\App\Exceptions\EntityNotFoundException $e) {
            throw new \App\Components\Api\Exception("User not found", 404);
        } catch (\App\Exceptions\CannotRemoveEntityException $e) {
            throw new \App\Components\Api\Exception("User cannot be deleted", 500);
        }
        return $this->response();
    }

    /**
     * @param String $id
     * @return mixed
     */
    public function postAvatar (String $id) {
        try {
            return $this->response([
                'avatar' => UserService::setAvatar($id)
            ]);
        } catch (\Exception $e) {
            throw new \App\Components\Api\Exception("Avatar cannot be saved", 500);
        }
    }

    /**
     * @param String $id
     * @return mixed
     * @throws \App\Components\Api\Exception
     */
    public function deleteAvatar (String $id) {
        try {
            UserService::deleteAvatar($id);
        } catch (\Exception $e) {
            throw new \App\Components\Api\Exception("Avatar cannot be deleted", 500);
        }
        return $this->response();
    }

}
