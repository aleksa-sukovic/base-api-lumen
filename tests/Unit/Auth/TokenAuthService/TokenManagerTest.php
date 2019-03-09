<?php

namespace Tests\Unit\Auth\TokenAuthService;

use Tests\TestCase;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Models\User;
use Illuminate\Support\Carbon;
use Aleksa\Library\Exceptions\TokenException;

class TokenManagerTest extends TestCase
{
    /**
     * @var TokenManager
     */
    protected $tokenManager;

    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->tokenManager = new TokenManager;
        $this->user = factory(User::class)->create([
            'email'     => 'sukovic.aleksa@gmail.com',
        ]);
    }

    public function test_decoding_token()
    {
        $encoded = $this->tokenManager->generate($this->user);
        $decoded = $this->tokenManager->decode($encoded['token']);

        $this->assertNotNull($encoded);

        $this->assertArrayHasKey('id', $decoded);
        $this->assertEquals($this->user->id, $decoded['id']);

        $this->assertArrayHasKey('email', $decoded);
        $this->assertEquals($this->user->email, $decoded['email']);

        $this->assertArrayHasKey('iss', $decoded);
        $this->assertEquals('Aleksa Sukovic', $decoded['iss']);
    }

    public function test_valid_token_date()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->addDays(15)->timestamp
        );

        $this->assertNotNull($this->tokenManager->decode($encodedToken['token']));
    }

    public function test_invalid_token_date()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->subDays(3)->timestamp,
            Carbon::now()->subDays(2)->timestamp
        )['token'];

        $this->expectException(TokenException::class);

        try {
            $this->tokenManager->decode($encodedToken);
        } catch (TokenException $exception) {
            $this->assertEquals(403, $exception->getStatusCode());

            throw new TokenException;
        }
    }

    public function test_validation_of_revoked_token()
    {
        $token = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->addHours(2)->timestamp
        )['token'];
        $this->user->reauth_requested_at = Carbon::now();
        $this->user->save();

        $token = $this->tokenManager->decode($token);

        $this->assertTrue($this->tokenManager->isTokenRevoked($token, $this->user));
    }
}
