<?php

namespace App\Exceptions;

class EntityNotFoundException extends \App\Components\Api\Exception
{
    protected $defaultCode = 404;

    protected $defaultMessage = "Entity not found";
}