<?php

namespace Aleksa\Auth\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next, $throwException = 'true')
    {
        $throwException = $throwException === 'false' ? false : true;

        $authService = app('Aleksa\Auth\Services\AuthService');

        $authService->setShouldThrowAuthException($throwException);
        $authService->authenticateRequest($request);

        return $next($request);
    }
}
