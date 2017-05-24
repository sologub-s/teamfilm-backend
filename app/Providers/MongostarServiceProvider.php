<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MongostarServiceProvider extends ServiceProvider{

    public function boot()
    {
        //dd(config('database.connections.mongodb_mongostar.driver'));
        //dd(config('database.connections.mongodb_mongostar.dir'));
        //dd(env('MONGODB_DRIVER'));

        \MongoStar\Config::setConfig([
            'driver' => config('database.connections.mongodb_mongostar.driver'),
            //'driver' => 'flat',
            'servers' => [
                [
                    'host' => config('database.connections.mongodb_mongostar.servers.0.host'),
                    'port' => config('database.connections.mongodb_mongostar.servers.0.port'),
                ],
            ],
            'db' => config('database.connections.mongodb_mongostar.database'),
            'pretty' => true,
        ]);
    }

    public function register()
    {
    }
}