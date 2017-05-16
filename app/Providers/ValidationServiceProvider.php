<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Validator;

use App\Validators\CustomValidator;

class ValidationServiceProvider extends ServiceProvider{

    public function boot()
    {

        /**
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new PhoneValidator($translator, $data, $rules, $messages);
        });
        */

        // will also work, we can use traits here instead of classes
        /*
        \Validator::extend('phone', function ($attribute, $value, $parameters) {
            return $value == "123";
        });
        */

        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

    public function register()
    {
    }
}