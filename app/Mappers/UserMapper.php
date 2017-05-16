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
            'email' => 'email',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'activated_at' => 'activated_at',
            'is_active' => 'is_active',
            'activation_token' => 'activation_token',
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
        ];
    }

    public function validate()
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
        ];
    }

    public function getPositions ($user) {
        return is_array($user->positions) ? $user->positions : [];
    }

    public function getEyes ($user) {
        return is_array($user->eyes) ? $user->eyes : [];
    }
}