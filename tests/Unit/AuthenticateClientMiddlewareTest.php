<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\Http\Middleware\AuthenticateClient;
use Bencoderus\MinAuth\Models\Client;
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
        $client = factory(Client::class)->create();

        $request = new Request();
        $request->headers->set('api_key', $this->faker->md5);

        $this->expectExceptionMessage("Api key is invalid");
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithAMissingApiKey()
    {
        $client = factory(Client::class)->create();

        // Given we have a request
        $request = new Request();

        $this->expectExceptionMessage("Api key is missing");
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithABlacklistedApiKey()
    {
        $client = factory(Client::class)->create(['is_blacklisted' => true]);

        // Given we have a request
        $request = new Request();
        $request->headers->set('api_key', $client->api_key);

        $this->expectExceptionMessage("Api key has been blacklisted");
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) {
            $this->assertNull($request->auth_client->name);
        });
    }

    public function testClientWithAValidApiKey()
    {
        $client = factory(Client::class)->create();

        $request = new Request();
        $request->headers->set('api_key', $client->api_key);

        Config::set(['min-auth.validate_ip' => false]);

        (new AuthenticateClient())->handle($request, function ($request) use ($client) {
            $this->assertSame($client->name, $request->auth_client->name);
        });
    }

    public function testClientWithAnInvalidIpAddress()
    {
        $client = factory(Client::class)->create();

        $request = new Request();
        $request->headers->set('api_key', $client->api_key);

        $this->expectExceptionMessage("Client Ip address is invalid");
        $this->expectException(AuthenticationException::class);

        (new AuthenticateClient())->handle($request, function ($request) use ($client) {
            $this->assertSame($client->name, $request->auth_client->name);
        });
    }
}
