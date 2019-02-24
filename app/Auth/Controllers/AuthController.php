<?php

namespace Aleksa\Auth\Controllers;

use Illuminate\Http\Request;
use Aleksa\Auth\Services\AuthService;
use Aleksa\Library\Facades\ApiRequest;

class AuthController
{

    /**
     * @var AuthService
     */
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
    }

    public function refresh(Request $request)
    {
    }

    public function revoke($id, Request $request)
    {
    }

    public function reset($id, Request $request)
    {
    }
}
