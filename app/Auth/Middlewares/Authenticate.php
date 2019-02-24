<?php

namespace Aleksa\Auth\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $authService = app('Aleksa\Auth\Services\AuthService');

        $authService->authenticateRequest($request);

        return $next($request);
    }
}
