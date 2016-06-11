<?php

namespace Zikkio\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Zikkio\Http\Behaviors\JsonApiResponses;

class Authenticate
{
    use JsonApiResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            return $this->respondUnauthenticated();
        }
        
        return $next($request);
    }
}
