<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Repositories\UserRepository;
use Aleksa\Library\Facades\Auth;
use Aleksa\Library\Exceptions\TokenException;
use Aleksa\Library\Exceptions\AuthException;
use Illuminate\Support\Carbon;
use Aleksa\Auth\Handlers\TokenPasswordHandler;
use Aleksa\Library\Services\Translator;

class TokenAuthService implements AuthService
{
    protected $tokenManager;
    protected $passwordHandler;
    protected $userRepository;
    protected $token;
    protected $user;
    protected $throwAuthException;

    public function __construct(TokenManager $tokenManager, TokenPasswordHandler $passwordHandler, UserRepository $userRepository)
    {
        $this->tokenManager = $tokenManager;
        $this->passwordHandler = $passwordHandler;
        $this->userRepository = $userRepository;
    }

    public function authenticateRequest(Request $request)
    {
        $this->validateRequest($request);

        Auth::setUser($this->user);
    }

    public function authenticateUser(Request $request)
    {
        $user = $this->passwordHandler->authenticateViaPassword($request);

        Auth::setUser($user);

        return $this->tokenManager->generate($user);
    }

    public function refreshAuthentication(Request $request)
    {
        $this->validateRequest($request);

        Auth::setUser($this->user);

        return $this->tokenManager->generate($this->user);
    }

    public function revokeAuthentication(Request $request)
    {
        $this->validateRequest($request);

        $this->user->reauth_requested_at = Carbon::now();
        $this->user->save();

        return [];
    }

    public function resetCredentials(Request $request)
    {
        $this->validateRequest($request);

        $this->passwordHandler->resetPassword($request, $this->user);

        return [];
    }

    public function shouldThrowAuthException(): bool
    {
        return $this->throwAuthException;
    }

    public function setShouldThrowAuthException(bool $throw): void
    {
        $this->throwAuthException = $throw;
    }

    protected function validateRequest(Request $request)
    {
        $token = $request->header('al-access-token');

        if (!$token && $this->shouldThrowAuthException()) {
            throw new AuthException(Translator::get('exceptions.token.required'));
        } elseif (!$token) {
            return;
        }

        $this->token = $this->tokenManager->decode($token);
        $this->user = $this->userRepository->findById($this->token['id']);

        if ($this->tokenManager->isTokenRevoked($this->token, $this->user)) {
            throw new TokenException(Translator::get('exceptions.token.required'));
        }
    }
}
