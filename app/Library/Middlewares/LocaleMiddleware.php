<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Aleksa\Library\Services\Locale;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Locale::set($request->header('locale'));

        return $next($request);
    }
}
