<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response as Response;

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
        if ($request->route()->parameter('id', 0) == 0) {
            return response()->json([
                'error' => Response::$statusTexts[Response::HTTP_FORBIDDEN],
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }

        return $next($request);
    }

}