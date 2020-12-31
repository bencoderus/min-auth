<?php

namespace Bencoderus\MinAuth;

use Bencoderus\MinAuth\Console\CreateClientCommand;
use Bencoderus\MinAuth\Console\InstallMinAuthCommand;
use Bencoderus\MinAuth\Http\Middleware\AuthenticateClient;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MinAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.client', AuthenticateClient::class);


        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallMinAuthCommand::class,
                CreateClientCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/min-auth.php' => config_path('min-auth.php'),
            ], 'config');

            if (! class_exists('CreateClientsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_clients_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_clients_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('min-auth', function () {
            return new MinAuth;
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/min-auth.php', 'min-auth');
    }
}
