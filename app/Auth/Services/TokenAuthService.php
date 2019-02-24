<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\User\Models\User;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Repositories\UserRepository;
use Aleksa\Library\Facades\Auth;
use Aleksa\Library\Exceptions\TokenException;

class TokenAuthService implements AuthService
{

    /**
     * @var TokenManager
     */
    protected $tokenManager;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(TokenManager $tokenManager, UserRepository $userRepository)
    {
        $this->tokenManager = $tokenManager;
        $this->userRepository = $userRepository;
    }

    public function authenticateRequest(Request $request)
    {
        $token = $request->header('al-access-token');

        if (!$token) {
            throw new TokenException('You must provide access token.');
        }

        $token = $this->tokenManager->decode($token);
        $user = $this->userRepository->findById($token['id']);

        if ($this->tokenManager->isTokenRevoked($token, $user)) {
            $user->reauth_requested_at = null;
            $user->save();

            throw new TokenException('Invalid Token. Please authenticate.');
        }

        Auth::setUser($user);
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
