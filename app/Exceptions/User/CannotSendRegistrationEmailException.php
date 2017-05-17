<?php

namespace App\Exceptions\User;

class CannotSendRegistrationEmailException extends \App\Components\Api\Exception
{
    protected $defaultMessage = "Cannot send registration email";
}