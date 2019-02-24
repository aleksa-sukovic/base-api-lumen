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
                Carbon::now()->timestamp,
                Carbon::now()->addHour()->timestamp
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
}
