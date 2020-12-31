<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CreateClientCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCommandWillCreateAClient(): void
    {
        Artisan::call('min-auth:create-client bencoderus');

        $this->assertDatabaseHas('clients', [
            'name' => 'bencoderus',
        ]);
    }
}
