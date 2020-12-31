<?php

namespace Bencoderus\MinAuth\Tests\Unit;

use Bencoderus\MinAuth\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommandTest extends TestCase
{
    public function testCommandInstalledAllTheNecessaryFiles(): void
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('min-auth.php'))) {
            unlink(config_path('min-auth.php'));
        }

        $this->assertFalse(File::exists(config_path('min-auth.php')));

        Artisan::call('min-auth:install');

        $this->assertTrue(File::exists(config_path('min-auth.php')));
        $this->assertTrue(class_exists('CreateClientsTable'));
    }
}
