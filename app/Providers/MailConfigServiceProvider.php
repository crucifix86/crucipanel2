<?php

namespace App\Providers;

use App\Mail\Transport\PhpMailTransport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Mail::extend('phpmail', function (array $config = []) {
            return new PhpMailTransport();
        });
    }
}