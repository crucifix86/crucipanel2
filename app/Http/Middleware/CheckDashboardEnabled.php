<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDashboardEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if player dashboard is enabled
        if (!config('pw-config.player_dashboard_enabled', true)) {
            // Redirect to home page if dashboard is disabled
            return redirect()->route('HOME')->with('error', 'The player dashboard is currently disabled.');
        }

        return $next($request);
    }
}