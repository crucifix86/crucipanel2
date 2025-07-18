<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateSliderCaptcha
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
        // Skip if captcha is disabled
        if (!config('pw-config.system.apps.captcha')) {
            return $next($request);
        }

        // Skip for GET requests
        if ($request->isMethod('get')) {
            return $next($request);
        }

        // Check if slider captcha verification token exists
        $token = $request->input('captcha_verified');
        
        if (empty($token)) {
            return back()->withErrors(['captcha' => __('captcha.required') ?? 'Please complete the captcha verification.']);
        }

        // Decode and validate token
        try {
            $decoded = base64_decode($token);
            list($timestamp, $position) = explode(':', $decoded);
            
            // Check if token is not older than 5 minutes
            if ((time() - ($timestamp / 1000)) > 300) {
                return back()->withErrors(['captcha' => __('captcha.expired') ?? 'Captcha verification expired. Please try again.']);
            }
            
            // Token is valid
            return $next($request);
        } catch (\Exception $e) {
            return back()->withErrors(['captcha' => __('captcha.invalid') ?? 'Invalid captcha verification.']);
        }
    }
}