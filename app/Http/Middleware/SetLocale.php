<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has language preference
        if (auth()->check() && auth()->user()->language) {
            App::setLocale(auth()->user()->language);
        } 
        // Check session for language preference
        elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // Default to config locale
        else {
            App::setLocale(config('app.locale', 'en'));
        }

        return $next($request);
    }
}
