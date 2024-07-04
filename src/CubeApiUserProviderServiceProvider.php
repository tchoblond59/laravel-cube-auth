<?php

namespace Tchoblond59\CubeAuth;

use Tchoblond59\CubeAuth\Guards\CubeGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Tchoblond59\CubeAuth\Providers\CubeUserProvider;

class CubeApiUserProviderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::provider('cube', function ($app, array $config) {
            return new CubeUserProvider();
        });

        Auth::extend('cube', function (Application $app, string $name, array $config) {
            return new CubeGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });

        $this->publishes([
            __DIR__.'/config/cube.php' => config_path('cube.php'),
        ], 'config');
    }

    public function register(): void
    {

    }
}
