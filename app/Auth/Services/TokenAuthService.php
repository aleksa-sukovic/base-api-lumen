<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\User\Models\User;
use Aleksa\Auth\Managers\TokenManager;

class TokenAuthService implements AuthService
{

    /**
     * @var TokenManager
     */
    protected $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function authenticateRequest(Request $request)
    {
    }

    public function authenticateUser(Request $request, User $user)
    {
    }

    public function refreshAuthentication(Request $request, User $user)
    {
    }

    public function revokeAuthentication(Request $request, User $user)
    {
    }

    public function resetCredentials(Request $request, User $user)
    {
    }
}
