<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\User\Models\User;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Repositories\UserRepository;
use Aleksa\Library\Facades\Auth;
use Aleksa\Library\Exceptions\TokenException;
use Aleksa\Library\Exceptions\AuthException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

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
            throw new TokenException('Invalid Token. Please authenticate.');
        }

        Auth::setUser($user);
    }

    public function authenticateUser(Request $request)
    {
        if (!$request->has('email') || !$request->has('password')) {
            throw new AuthException('You must provide email and password to authenticate.');
        }

        $user = $this->userRepository->findByEmail($request->input('email'));

        if (!Hash::check($request->input('password'), $user->password)) {
            throw new AuthException('Wrong password.');
        }

        Auth::setUser($user);

        return [
            'token' => $this->tokenManager->generate($user)
        ];
    }

    public function refreshAuthentication(Request $request)
    {
        $token = $request->header('al-access-token');

        if (!$token) {
            throw new AuthException('You must provide access token.');
        }

        $token = $this->tokenManager->decode($token);
        $user = $this->userRepository->findById($token['id']);

        if ($this->tokenManager->isTokenRevoked($token, $user)) {
            throw new TokenException('Invalid Token. Please authenticate.');
        }

        return [
            'token' => $this->tokenManager->generate($user)
        ];
    }

    public function revokeAuthentication(Request $request)
    {
        $token = $request->header('al-access-token');

        if (!$token) {
            throw new AuthException('You must provide access token.');
        }

        $token = $this->tokenManager->decode($token);
        $user = $this->userRepository->findById($token['id']);

        $user->reauth_requested_at = Carbon::now();
        $user->save();

        return [];
    }

    public function resetCredentials(Request $request, User $user)
    {
    }
}
