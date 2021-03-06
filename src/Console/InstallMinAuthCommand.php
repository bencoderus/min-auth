<?php

namespace Bencoderus\MinAuth\Console;

use Illuminate\Console\Command;

class InstallMinAuthCommand extends Command
{
    protected $signature = 'min-auth:install';

    protected $description = 'Install Min Auth Package';

    public function handle()
    {
        $this->info('Installing Min Auth...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Bencoderus\MinAuth\MinAuthServiceProvider",
            '--tag' => 'config',
        ]);

        if (! class_exists('CreateClientsTable')) {
            $this->call('vendor:publish', [
                '--provider' => "Bencoderus\MinAuth\MinAuthServiceProvider",
                '--tag' => 'migrations',
            ]);
        }

        $this->info('Min Auth Installed Successfully.');
    }
}
