<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\Models\Client;
use Bencoderus\MinAuth\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function testClientModelFactory()
    {
        $client = factory(Client::class)->create(['name' => 'Bencoderus']);

        $this->assertEquals('Bencoderus', $client->name);
    }
}
