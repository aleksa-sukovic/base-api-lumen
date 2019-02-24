<?php


namespace Aleksa\Auth\Managers;

use Aleksa\User\Models\User;
use Illuminate\Support\Carbon;
use Firebase\JWT\JWT;
use Aleksa\Library\Exceptions\TokenException;

class TokenManager
{
    public function refresh(string $token, User $user, $expirationTime = null)
    {
        if (!$expirationTime) {
            $expirationTime = env('AUTH_EXPIRATION_TIME');
        }

        $this->isValid($token, $user);

        return $this->generateToken($user, Carbon::now()->timestamp, Carbon::now()->addHours($expirationTime)->timestamp);
    }

    public function isValid(string $encodedToken, User $user)
    {
        try {
            $this->validateToken($encodedToken, $user);

            return true;
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new TokenException('Your token has expired. Please authenticate.');
        }
    }

    protected function validateToken(string $encodedToken, User $user)
    {
        $token = $this->decode($encodedToken);

        $this->validateUserData($token, $user);
    }

    public function decode($token): array
    {
        return (array) JWT::decode($token, env('AUTH_KEY'), [env('AUTH_ALGORITHM')]);
    }

    protected function validateUserData(array $token, User $user)
    {
        $toValidate = ['email', 'full_name', 'id'];

        foreach ($toValidate as $item) {
            if (!isset($token[$item]) || $token[$item] != $user[$item]) {
                throw new TokenException('Invalid access token. Please authenticate.');
            }
        }
    }

    public function generate(User $user)
    {
        $issuedAt = Carbon::now()->timestamp;
        $expiresAt = Carbon::now()->addHours(env('AUTH_EXPIRATION_TIME'))->timestamp;

        return $this->generateToken($user, $issuedAt, $expiresAt);
    }

    public function generateToken(User $user, int $issuedAt, int $expiresAt, string $issuer = 'Aleksa Sukovic', string $subject = 'Client')
    {
        $token = [
            'iss'            => $issuer,
            'sub'            => $subject,
            'exp'            => $expiresAt,
            'iat'            => $issuedAt,
            'jti'            => $user->id . '-' . $user->email,
            'id'             => $user->id,
            'full_name'      => $user->full_name,
            'email'          => $user->email
        ];

        return JWT::encode($token, env('AUTH_KEY'));
    }
}
