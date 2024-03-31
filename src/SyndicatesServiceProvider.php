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
        $this->registerPublishables();
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'syndicates');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'syndicates');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

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

    protected function registerPublishables(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/syndicates'),
        ], 'views');

    }
}
