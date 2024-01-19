<?php

namespace Mpob\Syndicates;

use Illuminate\Support\ServiceProvider;

class SyndicatesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'syndicates');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'syndicates');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('syndicates.php'),
            ], 'config');
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/syndicates.php', 'database.connections');

        // Register the main class to use with the facade
        $this->app->singleton('syndicates', function () {
            return new Syndicates;
        });
    }
}
