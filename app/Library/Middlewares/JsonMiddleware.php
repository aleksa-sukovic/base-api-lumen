<?php

namespace Aleksa\Library\Middlewares;

use Laravel\Lumen\Http\Request;
use Closure;

class JsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
