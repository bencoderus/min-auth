<?php

namespace Bencoderus\MinAuth\Console;

use Bencoderus\MinAuth\MinAuth;
use Illuminate\Console\Command;

class CreateClientCommand extends Command
{
    protected $signature = 'min-auth:create-client {name}';

    protected $description = 'Create a client.';

    public function handle()
    {
        $this->info('Creating a client...');

        $client = MinAuth::createClient($this->argument('name'));

        $this->info('Client created Successfully');
        $this->info($client->api_key);
    }
}
