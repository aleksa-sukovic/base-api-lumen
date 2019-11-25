<?php

namespace Aleksa\Library\Middlewares;

use Laravel\Lumen\Http\Request;
use Closure;
use Aleksa\Library\Facades\ApiRequest;

class ApiRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        ApiRequest::parseRequest($request);

        return $next($request);
    }
}
