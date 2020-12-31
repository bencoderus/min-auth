<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\Http\Middleware\AuthenticateClient;
use Bencoderus\MinAuth\MinAuth;
use Bencoderus\MinAuth\Tests\TestCase;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AuthenticateClientMiddlewareTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testClientWithAnInvalidApiKey()
    {
        $request = new Request();
        $request->headers->set(config('min-auth.header_name'), $this->faker->md5);

        $this->expectExceptionMessage('Api key is invalid');
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithAMissingApiKey()
    {
        // Given we have a request
        $request = new Request();

        $this->expectExceptionMessage('Api key is missing');
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithABlacklistedApiKey()
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName, '127.0.0.1', true);

        // Given we have a request
        $request = new Request();
        $request->headers->set(config('min-auth.header_name'), $client->api_key);

        $this->expectExceptionMessage('Api key has been blacklisted');
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithAValidApiKey()
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $request = new Request();
        $request->headers->set(config('min-auth.header_name'), $client->api_key);

        Config::set(['min-auth.validate_ip' => false]);

        (new AuthenticateClient())->handle($request, function ($request) use ($client) {
            $this->assertSame($client->name, $request->auth_client->name);
        });
    }

    public function testClientWithAnInvalidIpAddress()
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $request = new Request();
        $request->headers->set(config('min-auth.header_name'), $client->api_key);

        $this->expectExceptionMessage('Client Ip address is invalid');
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) use ($client) {
            $this->assertSame($client->name, $request->auth_client->name);
        });
    }
}
