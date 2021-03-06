<?php

namespace App\Mappers;

class UserMapper extends \MongoStar\Map
{
    /**
     * @return array
     */
    public function common() : array
    {
        return [
            'id' => 'uid',
        ];
    }

    public function api () : array
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'surname' => 'surname',
            'nickname' => 'nickname',
            'sex' => 'sex',
            'birthday' => 'birthday',
            'country' => 'country',
            'city' => 'city',
            'company' => 'company',
            'positions' => 'positions',
            'about' => 'about',
            'awards' => 'awards',
            'portfolio' => 'portfolio',
            'hasForeignPassport' => 'hasForeignPassport',
            'weight' => 'weight',
            'growth' => 'growth',
            'eyes' => 'eyes',
            'vocal' => 'vocal',
            'dance' => 'dance',
            'avatar' => 'avatar',
            'avatar_cropped' => 'avatar_cropped',
        ];
    }

    public function api_extended () : array
    {
        return array_merge($this->api(), [
            'email' => 'email',
            'cellphone' => 'cellphone',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'activated_at' => 'activated_at',
            'is_active' => 'is_active',
            'activation_token' => 'activation_token',
        ]);
    }

    public function service()
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'password' => 'password',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'activated_at' => 'activated_at',
            'is_active' => 'is_active',
            'activation_token' => 'activation_token',
            'access_tokens' => 'access_tokens',
            'name' => 'name',
            'surname' => 'surname',
            'nickname' => 'nickname',
            'cellphone' => 'cellphone',
            'sex' => 'sex',
            'birthday' => 'birthday',
            'country' => 'country',
            'city' => 'city',
            'company' => 'company',
            'positions' => 'positions',
            'about' => 'about',
            'awards' => 'awards',
            'portfolio' => 'portfolio',
            'hasForeignPassport' => 'hasForeignPassport',
            'weight' => 'weight',
            'growth' => 'growth',
            'eyes' => 'eyes',
            'vocal' => 'vocal',
            'dance' => 'dance',
            'avatar_cropped' => 'avatar_cropped',
        ];
    }

    public function getAccess_tokens ($user) : array {
        return is_array($user->access_tokens) ? $user->access_tokens : [];
    }

    public function getPositions ($user) : array {
        return is_array($user->positions) ? $user->positions : [];
    }

    public function getEyes ($user) : array {
        return is_array($user->eyes) ? $user->eyes : [];
    }

    public function getVocal ($user) : array {
        return is_array($user->vocal) ? $user->vocal : [];
    }

    public function getDance ($user) : array {
        return is_array($user->dance) ? $user->dance : [];
    }
}