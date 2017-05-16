<?php

namespace App\Validators;

class PhoneValidator extends \Illuminate\Validation\Validator
{

    public function validatePhone($attribute, $value, $parameters)
    {
        return $value == "123";
    }
}