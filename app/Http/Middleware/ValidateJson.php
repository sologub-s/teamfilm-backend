<?php

namespace App\Http\Middleware;

use Closure;

class ValidateJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->isJson()) {
            json_decode($request->getContent());
            if(json_last_error()) {
                throw new \App\Components\Api\Exception('Invalid JSON request body: ' . json_last_error_msg(), 400);
            }
        }

        return $next($request);
    }
}
