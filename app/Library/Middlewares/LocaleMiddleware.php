<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Aleksa\Library\Services\Lang;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Lang::set($request->header('locale'));

        return $next($request);
    }
}
