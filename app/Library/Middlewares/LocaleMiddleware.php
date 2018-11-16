<?php

namespace Aleksa\Library\Middlewares;

use Laravel\Lumen\Http\Request;
use Closure;
use Aleksa\Locale\Managers\LocaleManager;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        LocaleManager::locale($request->header('locale'));

        return $next($request);
    }
}
