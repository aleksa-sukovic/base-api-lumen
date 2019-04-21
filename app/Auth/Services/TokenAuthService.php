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
use Aleksa\User\Models\User;
use Illuminate\Support\Facades\Mail;
use Aleksa\User\Emails\UserCredentialsResetMail;

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
        $this->throwAuthException = true;
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

    public function requestCredentialsReset(Request $request, User $user)
    {
        $user->password_reset_code = str_random(5);
        $user->save();

        Mail::send(new UserCredentialsResetMail($user));

        return [];
    }

    public function resetCredentials(Request $request, User $user)
    {
        $this->passwordHandler->resetPassword($request, $user);

        $user->password_reset_code = null;
        $user->save();

        return [];
    }

    public function activateUser(Request $request, User $user)
    {
        $this->passwordHandler->initializePassword($request, $user);

        $user->activated = true;
        $user->activation_code = null;
        $user->save();

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

        try {
            $this->token = $this->tokenManager->decode($token);
            $this->user = $this->userRepository->findById($this->token['id']);

            if ($this->tokenManager->isTokenRevoked($this->token, $this->user)) {
                throw new TokenException(Translator::get('exceptions.token.required'));
            }

            if (!$this->user->isActivated() ) {
                throw new TokenException(Translator::get('exceptions.auth.not_activated'));
            }
        } catch (TokenException $e) {
            if ($this->shouldThrowAuthException()) {
                throw $e;
            }
        }
    }
}
