<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Illuminate\Http\JsonResponse;
use Aleksa\Library\Handlers\CorsHandler;

class CorsMiddleware
{
    protected $handler;

    public function __construct(CorsHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->handler->isAllowed($request)) {
            return new JsonResponse([], 403);
        }

        $response = $next($request);

        return $this->handler->modifyResponse($response);
    }
}
