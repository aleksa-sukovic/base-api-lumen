<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Repositories\UserRepository;
use Aleksa\Library\Facades\Auth;
use Aleksa\Library\Exceptions\TokenException;
use Aleksa\Library\Exceptions\AuthException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Aleksa\Library\Exceptions\ValidationException;

class TokenAuthService implements AuthService
{
    protected $tokenManager;
    protected $userRepository;
    protected $token;
    protected $user;

    public function __construct(TokenManager $tokenManager, UserRepository $userRepository)
    {
        $this->tokenManager = $tokenManager;
        $this->userRepository = $userRepository;
    }

    public function authenticateRequest(Request $request)
    {
        $this->parseRequest($request);

        Auth::setUser($this->user);
    }

    public function authenticateUser(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, ['email' => 'required|email', 'password' => 'required']);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $user = $this->userRepository->findByEmail($params['email']);
        if (!Hash::check($params['password'], $user->password)) {
            throw new AuthException('Wrong password.');
        }

        Auth::setUser($user);

        return $this->tokenManager->generate($user);
    }

    public function refreshAuthentication(Request $request)
    {
        $this->parseRequest($request);

        Auth::setUser($this->user);

        return $this->tokenManager->generate($this->user);
    }

    public function revokeAuthentication(Request $request)
    {
        $this->parseRequest($request);

        $this->user->reauth_requested_at = Carbon::now();
        $this->user->save();

        return [];
    }

    public function resetCredentials(Request $request)
    {
        $this->parseRequest($request);
        $params = $request->all();

        $validator = Validator::make($params, [
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
            'old_password'          => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        if (!Hash::check($params['old_password'], $this->user->password)) {
            throw new AuthException('Passwords do not match.');
        }

        $this->user->password = Hash::make($params['password']);
        $this->user->save();

        return [];
    }

    protected function parseRequest(Request $request)
    {
        $token = $request->header('al-access-token');

        if (!$token) {
            throw new AuthException('You must provide access token.');
        }

        $this->token = $this->tokenManager->decode($token);
        $this->user = $this->userRepository->findById($this->token['id']);

        if ($this->tokenManager->isTokenRevoked($this->token, $this->user)) {
            throw new TokenException('Invalid Token. Please authenticate.');
        }
    }
}
