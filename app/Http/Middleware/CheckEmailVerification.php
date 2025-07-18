<?php

namespace App\Http\Middleware;

use App\Models\WelcomeMessageSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerification
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
        $user = Auth::user();
        
        if (!$user) {
            return $next($request);
        }
        
        // Get email verification setting
        $settings = WelcomeMessageSetting::first();
        
        // If email verification is enabled and user hasn't verified
        if ($settings && $settings->email_verification_enabled && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        
        return $next($request);
    }
}