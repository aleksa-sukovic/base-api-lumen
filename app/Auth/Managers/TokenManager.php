<?php


namespace Aleksa\Auth\Managers;

use Aleksa\User\Models\User;
use Illuminate\Support\Carbon;
use Firebase\JWT\JWT;
use Aleksa\Library\Exceptions\TokenException;
use Aleksa\Library\Services\Translator;

class TokenManager
{
    public function decode($token): array
    {
        try {
            $token = (array) JWT::decode($token, env('AUTH_KEY'), [env('AUTH_ALGORITHM')]);

            $this->validateRequired($token);

            return $token;
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new TokenException(Translator::get('exceptions.token.expired'));
        } catch (\Exception $e) {
            throw new TokenException(Translator::get('exceptions.token.invalid'));
        }
    }

    protected function validateRequired(array $token)
    {
        $toValidate = ['email', 'id', 'iss', 'sub', 'exp', 'iat', 'jti'];

        foreach ($toValidate as $item) {
            if (!isset($token[$item])) {
                throw new TokenException(Translator::get('exceptions.token.invalid'));
            }
        }
    }

    public function isTokenRevoked(array $token, User $user)
    {
        $tokenIssueDate = Carbon::createFromTimestamp($token['iat']);

        if (!$user->reauth_requested_at) {
            return false;
        }

        return $tokenIssueDate->lt($user->reauth_requested_at);
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
            'email'          => $user->email
        ];

        return [
            'id'             => $user->id,
            'full_name'      => $user->full_name,
            'email'          => $user->email,
            'issued_at'      => Carbon::createFromTimestamp($issuedAt)->toDateTimeString(),
            'expires_at'     => Carbon::createFromTimestamp($expiresAt)->toDateTimeString(),
            'token'          => JWT::encode($token, env('AUTH_KEY'))
        ];
    }
}
