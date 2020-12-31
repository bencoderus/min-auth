<?php

namespace Bencoderus\MinAuth\Http\Middleware;

use Bencoderus\MinAuth\MinAuth;
use Closure;
use Illuminate\Auth\AuthenticationException;

class AuthenticateClient
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (! $apiKey = $request->header(config('min-auth.header_name'))) {
            throw new AuthenticationException('Api key is missing');
        }

        if (! $client = MinAuth::findByApiKey($apiKey)) {
            throw new AuthenticationException('Api key is invalid');
        }

        if ($client->is_blacklisted) {
            throw new AuthenticationException('Api key has been blacklisted');
        }

        if (! $this->validateIp($request, $client)) {
            throw new AuthenticationException('Client Ip address is invalid');
        }

        $request->merge(['auth_client' => $client]);

        return $next($request);
    }

    /**
     * Validate client IP Address.
     *
     * @param $request
     * @param $client
     * @return bool
     */
    private function validateIp($request, $client): bool
    {
        if (! config('min-auth.validate_ip')) {
            return true;
        }

        return $request->ip() === $client->ip;
    }
}
