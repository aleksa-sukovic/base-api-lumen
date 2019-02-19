<?php

namespace Aleksa\Library\Handlers;

use Laravel\Lumen\Http\Request;
use Illuminate\Http\Response;

class CorsHandler
{
    protected $request;
    protected $allowedDomains;
    protected $allowedMethods;
    protected $allowedHeaders;

    public function __construct(Request $request)
    {
        $this->$request = $request;
        $this->allowedDomains = explode('|', env('ALLOWED_DOMAINS'));
        $this->allowedMethods = explode('|', env('ALLOWED_METHODS'));
        $this->allowedHeaders = explode('|', env('ALLOWED_HEADERS'));
    }

    public function isAllowed()
    {
        return in_array($this->request->header('Origin'), $this->allowedDomains);
    }

    public function modifyResponse(Response $response): Response
    {
        $response = $this->addAllowedDomains($response);
        $response = $this->addAllowedMethods($response);
        $response = $this->addAllowedHeader($response);

        return $response;
    }

    protected function addAllowedDomains($response)
    {
        $response->header('Access-Control-Allow-Origin', $this->request->header('Origin'));

        return $response;
    }

    protected function addAllowedMethods($response)
    {
        $response->header('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods));

        return $response;
    }

    protected function addAllowedHeader($response)
    {
        $this->allowedHeaders[] = 'Access-Control-Allow-Headers';
        $this->allowedHeaders[] = 'Access-Control-Allow-Origin';
        $this->allowedHeaders[] = 'Access-Control-Allow-Methods';

        $response->header('Access-Control-Allow-Headers', implode(', ', $this->allowedHeaders));

        return $response;
    }
}
