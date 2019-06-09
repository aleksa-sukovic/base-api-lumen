<?php

namespace Tests\Unit\Auth\TokenAuthService;

use \Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Aleksa\User\Models\User;
use Aleksa\Library\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

    public function setUp(): void
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

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_user_authentication_success()
    {
        $this->request->shouldReceive('all')->once()->andReturn([
            'email'    => 'sukovic.aleksa@gmail.com',
            'password' => '123123'
        ]);

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
        $this->request->shouldReceive('all')->once()->andReturn([
            'email'    => 'sukovic.aleksa@gmail.com',
            'password' => 'wrong_password'
        ]);

        $this->expectException('Aleksa\Library\Exceptions\AuthException');

        $this->authService->authenticateUser($this->request);
    }

    public function test_user_authentication_invalid_user()
    {
        $this->request->shouldReceive('all')->once()->andReturn([
            'email'    => 'invalid@gmail.com',
            'password' => '123123'
        ]);

        $this->expectException('Aleksa\Library\Exceptions\ItemNotFoundException');

        $this->authService->authenticateUser($this->request);
    }

    public function test_token_refresh_failure()
    {
        $this->request->shouldReceive('header')->once()
            ->with('al-access-token')->andReturnNull();

        $this->expectException('Aleksa\Library\Exceptions\AuthException');

        $this->authService->refreshAuthentication($this->request);
    }
}
