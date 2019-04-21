<?php

namespace Aleksa\Auth\Controllers;

use Illuminate\Http\Request;
use Aleksa\Auth\Services\AuthService;
use Aleksa\Library\Controllers\BaseController;
use Aleksa\Library\Facades\Auth;
use Aleksa\User\Transformers\UserTransformer;
use Aleksa\Library\Services\Translator;
use Aleksa\Library\Exceptions\UnauthorizedException;

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

    public function reset($code, Request $request)
    {
        $user = users()->findByPasswordResetCode($code);

        $data = $this->authService->resetCredentials($request, $user);

        return $this->respond($data, 200, 'Success');
    }

    public function activate($code, Request $request)
    {
        $user = users()->findByCode($code);

        $data = $this->authService->activateUser($request, $user);

        return $this->respond($data, 200, 'Success');
    }

    public function requestReset(Request $request)
    {
        if ($request->has('user_id') && !Auth::getUser()->isSuperAdmin()) {
            throw new UnauthorizedException;
        }

        $id = $request->has('user_id') ? $request->input('user_id') : Auth::getUser()->id;
        $data = $this->authService->requestCredentialsReset($request, users()->findById($id));

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
