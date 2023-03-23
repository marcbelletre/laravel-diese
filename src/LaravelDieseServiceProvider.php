<?php

namespace MarcBelletre\LaravelDiese;

use Illuminate\Support\ServiceProvider;

class LaravelDieseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/diese.php' => config_path('diese.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/diese.php', 'diese');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-diese', function () {
            return new LaravelDiese;
        });
    }
}
