<?php

namespace App\Services;

abstract class AbstractService
{
    /**
     * @return bool|array
     */
    abstract public static function isValid(\App\Models\AbstractModel $model);
}