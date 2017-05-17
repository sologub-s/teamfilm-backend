<?php

namespace App\Exceptions;

class CannotRemoveEntityException extends \App\Components\Api\Exception
{
    protected $defaultMessage = "Entity cannot be removed";
}