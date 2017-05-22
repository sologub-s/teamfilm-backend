<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider{

    public function boot()
    {

        \Storage\Storage::setConfig(['uri' => config('services.storage.url'),]);
        \Storage\Storage::setToken(config('services.storage.token'));
    }

    public function register()
    {
    }
}