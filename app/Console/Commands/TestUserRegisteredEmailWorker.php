<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestUserRegisteredEmailWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:user:registered:email:worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing emails for newly registered users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while(true) {
            Redis::publish('test-channel', 'Hello world at ' . (new \DateTime())->format('Y-m-d H:i:s'));
            sleep(3);
        }
    }
}
