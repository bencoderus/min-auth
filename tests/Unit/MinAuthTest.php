<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\MinAuth;
use Bencoderus\MinAuth\Models\Client;
use Bencoderus\MinAuth\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MinAuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testFindAClientWithAValidApiKey(): void
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $foundClient = MinAuth::findByApiKey($client->api_key);

        $this->assertEquals($foundClient->name, $client->name);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFindAClientWithAnInValidApiKey(): void
    {
        $foundClient = MinAuth::findByApiKey($this->faker->md5);

        $this->assertNull($foundClient);
    }

    public function testGenerateApiKey(): void
    {
        $apiKey = MinAuth::generateApiKey();

        $this->assertIsString($apiKey);
        $this->assertTrue(strlen($apiKey) > 10);
    }

    public function testUpdateClientIpAddress(): void
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $ipAddress = $this->faker->ipv4;

        $client = MinAuth::updateIpAddress($client, $ipAddress);

        $this->assertSame($ipAddress, $client->ip);
        $this->assertDatabaseHas('clients', [
            'ip' => $ipAddress,
        ]);
    }

    public function testBlacklistAClient(): void
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $client = MinAuth::blacklistClient($client);

        $this->assertTrue($client->is_blacklisted);
    }

    public function testWhitelistAClient(): void
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName, '127.0.0.1', true);

        $client = MinAuth::WhitelistClient($client);

        $this->assertFalse($client->is_blacklisted);
    }

    public function testCreateAClient(): void
    {
        $clientName = 'Bencoderus';
        $client = MinAuth::createClient($clientName);

        $this->assertIsString($client->name);
        $this->assertDatabaseHas('clients', [
            'name' => $clientName,
        ]);
    }
}
