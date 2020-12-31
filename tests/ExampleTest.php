<?php

namespace Bencoderus\MinAuth\Tests;

use Bencoderus\MinAuth\MinAuthServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [MinAuthServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
