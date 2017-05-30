<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response as Response;
use App\Services\UserService;

class Authorization
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!($xAuth = $request->header('X-Auth', null)) || !UserService::getUserByAccessToken($xAuth, true)){
            throw new \App\Components\Api\Exception('Not authorized', 403);
        }

        return $next($request);
    }

}