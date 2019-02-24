<?php

namespace Tests\Unit\Auth\TokenAuthService;

use \Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Aleksa\User\Models\User;
use Aleksa\Library\Facades\Auth;
use Carbon\Carbon;

class TokenAuthServiceTest extends TestCase
{
    /**
     * @var TokenManager
     */
    protected $tokenManager;

    /**
     * @var AuthService;
     */
    protected $authService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->authService = app('Aleksa\Auth\Services\TokenAuthService');
        $this->tokenManager = app('Aleksa\Auth\Managers\TokenManager');
        $this->user = factory(User::class)->create([
            'full_name' => 'Aleksa Sukovic',
            'email'     => 'sukovic.aleksa@gmail.com'
        ]);
        $this->request = Mockery::mock(Request::class)->makePartial();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_request_authentication_succeeded()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturn($this->tokenManager->generate($this->user));

        $this->authService->authenticateRequest($this->request);

        $this->assertEquals($this->user->id, Auth::getUser()->id);
    }

    public function test_request_authentication_missing_token()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturnNull();

        $this->expectException('Aleksa\Library\Exceptions\TokenException');

        $this->authService->authenticateRequest($this->request);
    }

    public function test_request_authentication_invalid_token()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturn('this_is_invalid_token_data');

        $this->expectException('Aleksa\Library\Exceptions\TokenException');

        $this->authService->authenticateRequest($this->request);
    }

    public function test_request_authentication_user_not_exists()
    {
        $user = factory(User::class)->make(['id' => 10]);
        $token = $this->tokenManager->generate($user);
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturn($token);

        $this->expectException('Aleksa\Library\Exceptions\ItemNotFoundException');

        $this->authService->authenticateRequest($this->request);
    }

    public function test_request_token_revoked()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturn($this->tokenManager->generateToken(
                $this->user,
                Carbon::now()->subHours(2)->timestamp,
                Carbon::now()->addHours(4)->timestamp
            ));

        $this->user->reauth_requested_at = Carbon::now();
        $this->user->save();

        $this->expectException('Aleksa\Library\Exceptions\TokenException');

        $this->authService->authenticateRequest($this->request);
    }

    public function test_user_authentication_success()
    {
        $this->request->shouldReceive('has')->with('email')->andReturnTrue();
        $this->request->shouldReceive('has')->with('password')->andReturnTrue();

        $this->request->shouldReceive('input')->with('email')
            ->andReturn('sukovic.aleksa@gmail.com');
        $this->request->shouldReceive('input')->with('password')
            ->andReturn('123123');

        $data = $this->authService->authenticateUser($this->request);

        $this->assertEquals($this->user->id, Auth::getUser()->id);
        $this->assertNotNull($data);
        $this->assertArrayHasKey('token', $data);

        $decodedToken = $this->tokenManager->decode($data['token']);
        $this->assertEquals(
            $this->user->id,
            $decodedToken['id']
        );
    }

    public function test_user_authentication_fails()
    {
        $this->request->shouldReceive('has')->with('email')->andReturnTrue();
        $this->request->shouldReceive('has')->with('password')->andReturnTrue();

        $this->request->shouldReceive('input')->with('email')
            ->andReturn('sukovic.aleksa@gmail.com');
        $this->request->shouldReceive('input')->with('password')
            ->andReturn('wrong_password');

        $this->expectException('Aleksa\Library\Exceptions\AuthException');

        $this->authService->authenticateUser($this->request);
    }

    public function test_user_authentication_invalid_user()
    {
        $this->request->shouldReceive('has')->with('email')->andReturnTrue();
        $this->request->shouldReceive('has')->with('password')->andReturnTrue();

        $this->request->shouldReceive('input')->with('email')
            ->andReturn('invalid@gmail.com');
        $this->request->shouldReceive('input')->with('password')
            ->andReturn('123123');

        $this->expectException('Aleksa\Library\Exceptions\ItemNotFoundException');

        $this->authService->authenticateUser($this->request);
    }

    public function test_token_refresh_success()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturn($this->tokenManager->generate($this->user));

        $data = $this->authService->refreshAuthentication($this->request);

        $this->assertNotNull($data);
        $this->assertArrayHasKey('token', $data);

        $token = $this->tokenManager->decode($data['token']);
        $this->assertEquals($this->user->id, $token['id']);
    }

    public function test_token_refresh_failure()
    {
        $this->request->shouldReceive('header')->once()
            ->with('al-access-token')->andReturnNull();

        $this->expectException('Aleksa\Library\Exceptions\AuthException');

        $this->authService->refreshAuthentication($this->request);
    }

    public function test_revoke_authentication_success()
    {
        $token = $this->tokenManager->generate($this->user);
        $this->request->shouldReceive('header')->once()
            ->with('al-access-token')->andReturn($token);

        $this->authService->revokeAuthentication($this->request);
        $this->user->refresh();

        $this->assertNotNull($this->user->reauth_requested_at);
        $this->assertEquals(0, Carbon::now()->diffInHours(
            Carbon::createFromTimeString($this->user->reauth_requested_at)
        ));
    }
}
