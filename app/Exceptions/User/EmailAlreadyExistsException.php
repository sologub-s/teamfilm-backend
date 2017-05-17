<?php

namespace App\Exceptions\User;

class EmailAlreadyExistsException extends \App\Components\Api\Exception
{
    protected $defaultMessage = "User with this email already exists";
}