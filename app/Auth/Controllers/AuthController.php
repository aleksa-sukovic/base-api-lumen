<?php

namespace Aleksa\Auth\Controllers;

use Illuminate\Http\Request;
use Aleksa\Auth\Services\AuthService;
use Aleksa\Library\Controllers\BaseController;

class AuthController extends BaseController
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
        $data = (array) $this->authService->authenticateUser($request);

        return $this->respond($data, 200, 'Success');
    }

    public function refresh(Request $request)
    {
        $data = $this->authService->refreshAuthentication($request);

        return $this->respond($data, 200, 'Success');
    }

    public function revoke(Request $request)
    {
        $data = $this->authService->revokeAuthentication($request);

        return $this->respond($data, 200, 'Success revoked all of yours access tokens.');
    }

    public function reset(Request $request)
    {
        $data = $this->authService->resetCredentials($request);

        return $this->respond($data, 200, 'Success');
    }
}
