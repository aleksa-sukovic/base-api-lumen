<?php

namespace Tests\Auth\TokenAuthService;

use Tests\TestCase;
use Aleksa\Auth\Managers\TokenManager;
use Aleksa\User\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;

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

    public function setUp()
    {
        parent::setUp();

        $this->tokenManager = new TokenManager;
        $this->user = factory(User::class)->create([
            'full_name' => 'Aleksa Sukovic',
            'email'     => 'sukovic.aleksa@gmail.com',
        ]);
    }

    public function test_decoding_token()
    {
        $encoded = $this->tokenManager->generate($this->user);
        $decoded = $this->tokenManager->decode($encoded);

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

        $this->assertTrue($this->tokenManager->isValid($encodedToken, $this->user));
    }

    public function test_invalid_token_date()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->subDays(3)->timestamp,
            Carbon::now()->subDays(2)->timestamp
        );

        $this->expectException('Aleksa\Library\Exceptions\TokenException');
        $this->assertFalse($this->tokenManager->isValid($encodedToken, $this->user));
    }

    public function test_token_validation_for_user_succeeded()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->addDays(2)->timestamp
        );

        $this->assertTrue($this->tokenManager->isValid($encodedToken, $this->user));
    }

    public function test_token_validation_for_user_fails()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->addDays(2)->timestamp
        );

        $anotherUser = factory(User::class)->create();

        $this->expectException('Aleksa\Library\Exceptions\TokenException');

        $this->tokenManager->isValid($encodedToken, $anotherUser);
    }

    public function test_refreshing_token()
    {
        $encodedToken = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->addHours(1)->timestamp
        );
        $oldToken = $this->tokenManager->decode($encodedToken);

        $refreshedToken = $this->tokenManager->refresh($encodedToken, $this->user, 2);
        $refreshedToken = $this->tokenManager->decode($refreshedToken);

        $oldExpirationDate = Carbon::createFromTimestamp($oldToken['exp']);
        $newExpirationDate = Carbon::createFromTimestamp($refreshedToken['exp']);

        $this->assertEquals(1, $oldExpirationDate->diffInHours($newExpirationDate));
    }

    public function test_refreshing_token_fails()
    {
        $token = $this->tokenManager->generateToken(
            $this->user,
            Carbon::now()->timestamp,
            Carbon::now()->subHours(4)->timestamp
        );

        $this->expectException('Aleksa\Library\Exceptions\TokenException');

        $this->tokenManager->refresh($token, $this->user);
    }
}
