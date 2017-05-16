<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MongostarServiceProvider extends ServiceProvider{

    public function boot()
    {
        \MongoStar\Config::setConfig([
            'driver' => 'mongodb',
            'servers' => [
                ['host' => 'localhost', 'port' => '27017'],
                //['host' => 'host2', 'port' => 'port2']
            ],
            //'replicaSetName' => 'rs0',
            'db' => 'teamfilm',
            //'username' => 'username',
            //'password' => 'password',
        ]);
    }

    public function register()
    {
    }
}