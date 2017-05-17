<?php

namespace App\Exceptions;

class CannotSaveEntityException extends \App\Components\Api\Exception
{
    protected $defaultMessage = "Entity cannot be saved";
}