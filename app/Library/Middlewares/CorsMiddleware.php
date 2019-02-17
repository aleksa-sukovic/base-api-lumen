<?php

namespace Aleksa\Library\Middlewares;

use Closure;
use Laravel\Lumen\Http\Request;
use Illuminate\Http\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response = $this->addAllowedDomains($response, $request);
        $response = $this->addAllowedMethods($response);
        $response = $this->addAllowedHeader($response);

        return $response;
    }

    protected function addAllowedDomains($response, Request $request)
    {
        $domains = explode('|', env('ALLOWED_DOMAINS'));

        if (in_array($request->header('Origin'), $domains)) {
            $response->header('Access-Control-Allow-Origin', $request->header('Origin'));
        }

        return $response;
    }

    protected function addAllowedMethods($response)
    {
        $methods = explode('|', env('ALLOWED_METHODS'));

        $response->header('Access-Control-Allow-Methods', implode(', ', $methods));

        return $response;
    }

    protected function addAllowedHeader($response)
    {
        $headers = explode('|', env('ALLOWED_HEADERS'));

        $headers[] = 'Access-Control-Allow-Headers';
        $headers[] = 'Access-Control-Allow-Origin';
        $headers[] = 'Access-Control-Allow-Methods';

        $response->header('Access-Control-Allow-Headers', implode(', ', $headers));

        return $response;
    }
}
