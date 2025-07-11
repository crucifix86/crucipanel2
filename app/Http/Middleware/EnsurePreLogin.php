<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePreLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Always allow authenticated users
        if (auth()->check()) {
            return $next($request);
        }

        // Skip pre-login for these routes
        $skipRoutes = [
            'api.check-pin',
            'password.request',
            'password.email', 
            'password.reset',
            'password.update',
            'logout',
            'register',  // Add register route to skip list
            'public.rankings',  // Add public rankings route
            'public.shop',  // Add public shop route
            'public.donate',  // Add public donate route
            'public.vote',  // Add public vote route
        ];

        // Skip for any POST request to login route (both named and unnamed)
        if ($request->isMethod('post') && $request->path() === 'login') {
            return $next($request);
        }

        // Skip for POST register request
        if ($request->isMethod('post') && $request->path() === 'register') {
            return $next($request);
        }

        // Skip if accessing one of the allowed routes
        if ($request->route() && in_array($request->route()->getName(), $skipRoutes)) {
            return $next($request);
        }

        // For any other route when not authenticated, show the pre-login page
        return response()->view('auth.pre-login');
    }
}