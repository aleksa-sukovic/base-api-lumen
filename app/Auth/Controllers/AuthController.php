<?php

namespace Aleksa\Auth\Controllers;

use Illuminate\Http\Request;
use Aleksa\Auth\Services\AuthService;
use Aleksa\Library\Controllers\BaseController;
use Aleksa\Library\Facades\Auth;
use Aleksa\User\Transformers\UserTransformer;

class AuthController extends BaseController
{

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @var UserTransformer
     */
    protected $userTransformer;

    public function __construct(AuthService $authService, UserTransformer $userTransformer)
    {
        parent::__construct();

        $this->authService = $authService;
        $this->userTransformer = $userTransformer;
    }

    public function login(Request $request)
    {
        $data = (array) $this->authService->authenticateUser($request);

        $data['user'] = $this->getUserData();

        return $this->respond($data, 200, 'Success');
    }

    public function refresh(Request $request)
    {
        $data = $this->authService->refreshAuthentication($request);

        $data['user'] = $this->getUserData();

        return $this->respond($data, 200, 'Success');
    }

    public function revoke(Request $request)
    {
        $data = $this->authService->revokeAuthentication($request);

        return $this->respond($data, 200, 'Successfully revoked all of yours access tokens.');
    }

    public function reset(Request $request)
    {
        $data = $this->authService->resetCredentials($request);

        return $this->respond($data, 200, 'Success');
    }

    private function getUserData()
    {
        $user = Auth::getUser();
        $user->load('group');

        $transformed = $this->userTransformer->transform($user);
        $transformed['group'] = $user->group;

        return $transformed;
    }
}
