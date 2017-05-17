<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider{

    public function boot()
    {

        \Storage\Storage::setConfig(['uri' => config('services.storage.url'),]);
        \Storage\Storage::setToken(config('services.storage.token'));

        \MongoStar\Config::setConfig([
            'driver' => config('database.connections.mongodb_mongostar.driver'),
            'servers' => [
                [
                    'host' => config('database.connections.mongodb_mongostar.servers.0.host'),
                    'port' => config('database.connections.mongodb_mongostar.servers.0.port'),
                ],
            ],
            'db' => config('database.connections.mongodb_mongostar.database'),
        ]);
    }

    public function register()
    {
    }
}