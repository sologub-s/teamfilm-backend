<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Validator;

use App\Validators\CustomValidator;

class ValidationServiceProvider extends ServiceProvider{

    public function boot()
    {

        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

    public function register()
    {
    }
}