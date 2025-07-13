<?php

namespace App\Providers;

use App\Services\LocalSettingsService;
use Illuminate\Support\ServiceProvider;

class LocalSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('local-settings', function ($app) {
            return new LocalSettingsService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}