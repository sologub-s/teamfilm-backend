<?php

namespace App\Exceptions;

class InvalidEntityException extends \App\Components\Api\Exception
{
    protected $defaultCode = 400;

    protected $defaultMessage = "Entity in invalid";
}