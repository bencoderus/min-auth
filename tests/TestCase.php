<?php

namespace Bencoderus\MinAuth\Tests;

use Bencoderus\MinAuth\MinAuthServiceProvider;
use Orchestra\Testbench\TestCase as MainCase;

class TestCase extends MainCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [MinAuthServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->runMigrations();
    }

    private function runMigrations()
    {
        // import the CreatePostsTable class from the migration
        include_once __DIR__ . '/../database/migrations/create_clients_table.php.stub';

        // run the up() method of that migration class
        (new \CreateClientsTable)->up();
    }
}
