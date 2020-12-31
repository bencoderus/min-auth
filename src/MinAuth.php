<?php

namespace Bencoderus\MinAuth;

use Bencoderus\MinAuth\Models\Client;
use Illuminate\Support\Str;

class MinAuth
{
    /**
     * Create a client using the client name.
     *
     * @param string $name
     * @param string $ip
     * @param bool $isBlacklisted
     * @return \Bencoderus\MinAuth\Models\Client
     */
    public static function createClient(string $name, string $ip = "127.0.0.1", bool $isBlacklisted = false): Client
    {
        return Client::create([
            'name' => $name,
            'api_key' => self::generateApiKey(),
            'ip' => $ip,
            'is_blacklisted' => $isBlacklisted,
        ]);
    }

    /**
     * Generate an API key for a client.
     *
     * @return string
     */
    public static function generateApiKey(): string
    {
        do {
            $apiKey = Str::uuid();
        } while (Client::whereApiKey($apiKey)->exists());

        return $apiKey;
    }

    /**
     * Update Client Ip Address.
     *
     * @param \Bencoderus\MinAuth\Models\Client $client
     * @param string $ip
     * @return \Bencoderus\MinAuth\Models\Client
     */
    public static function updateIpAddress(Client $client, string $ip): Client
    {
        $client->update(['ip' => $ip]);

        return $client;
    }

    /**
     * Blacklist a client.
     *
     * @param \Bencoderus\MinAuth\Models\Client $client
     * @return \Bencoderus\MinAuth\Models\Client
     */
    public static function blacklistClient(Client $client): Client
    {
        $client->update(['is_blacklisted' => true]);

        return $client;
    }

    /**
     * Whitelist a Blacklisted Client.
     *
     * @param \Bencoderus\MinAuth\Models\Client $client
     * @return \Bencoderus\MinAuth\Models\Client
     */
    public static function whitelistClient(Client $client): Client
    {
        $client->update(['is_blacklisted' => false]);

        return $client;
    }

    /**
     * Find a client using their API key.
     *
     * @param string $apiKey
     * @return mixed
     */
    public static function findByApiKey(string $apiKey)
    {
        return Client::whereApiKey($apiKey)->first();
    }
}
