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
        $this->loadViewsFrom(__DIR__ . '/views', 'syndicates');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/views' => base_path('resources/views/mpob-modules'),
            ]);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration

        // Register the main class to use with the facade
        $this->app->singleton('syndicates', function () {
            return new Syndicates;
        });
    }
}
