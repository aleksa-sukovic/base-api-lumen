<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Illuminate\Http\JsonResponse;
use Aleksa\Library\Handlers\CorsHandler;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $handler = new CorsHandler($request);

        if (!$handler->isAllowed($request)) {
            return new JsonResponse([], 403);
        }

        $response = $next($request);

        return $handler->modifyResponse($response);
    }
}
