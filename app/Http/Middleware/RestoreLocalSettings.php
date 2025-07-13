<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Facades\LocalSettings;

class RestoreLocalSettings
{
    /**
     * Handle an incoming request.
     * This middleware restores settings from local storage to config
     */
    public function handle(Request $request, Closure $next)
    {
        // Get all local settings
        $settings = LocalSettings::all();
        
        // Restore each setting to config
        foreach ($settings as $key => $value) {
            config([$key => $value]);
        }
        
        return $next($request);
    }
}