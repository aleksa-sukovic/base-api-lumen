<?php

namespace Tests\Unit\ApiRequest;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Aleksa\Library\Facades\ApiRequest;

class ApiRequestServiceTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock(Request::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_parsing_token()
    {
        $this->request->shouldReceive('header')
            ->with('al-access-token')
            ->andReturn('valid_token');

        ApiRequest::parseRequest($this->request);

        $this->assertTrue(ApiRequest::hasToken());
        $this->assertSame('valid_token', ApiRequest::getToken());
    }

    public function test_empty_token()
    {
        $this->request->shouldReceive('header')
            ->once()
            ->with('al-access-token')
            ->andReturnNull();

        ApiRequest::parseRequest($this->request);

        $this->assertFalse(ApiRequest::hasToken());
    }
}
