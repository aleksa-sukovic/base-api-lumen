<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Aleksa\Library\Services\LocaleService;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        LocaleService::set($request->header('locale'));

        return $next($request);
    }
}
