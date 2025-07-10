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

        // For login route, show the pre-login page instead
        if ($request->route()->getName() === 'login' && $request->isMethod('get')) {
            return response()->view('auth.pre-login');
        }

        return $next($request);
    }
}