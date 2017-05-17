<?php

namespace App\Exceptions\User;

class NicknameAlreadyExistsException extends \App\Components\Api\Exception
{
    protected $defaultMessage = "User with this nickname already exists";
}