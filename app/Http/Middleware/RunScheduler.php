<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RunScheduler
{
    /**
     * Handle an incoming request.
     * Triggers scheduled tasks in the background
     */
    public function handle(Request $request, Closure $next)
    {
        // Only run on GET requests to avoid interfering with forms
        if ($request->isMethod('get')) {
            $this->triggerScheduler();
        }
        
        return $next($request);
    }
    
    /**
     * Trigger the scheduler in the background
     */
    protected function triggerScheduler()
    {
        // Check if enabled
        if (!config('pw-config.scheduler.enabled', true)) {
            return;
        }
        
        // Check if we should run (every 30 seconds)
        $lastTrigger = Cache::get('scheduler:last_trigger', 0);
        if (time() - $lastTrigger < 30) {
            return;
        }
        
        Cache::put('scheduler:last_trigger', time(), 60);
        
        // Trigger scheduler via async HTTP request
        try {
            // Build URL using current request's domain
            $request = request();
            $scheme = $request->secure() ? 'https' : 'http';
            $host = $request->getHost();
            $port = $request->getPort();
            
            // Build base URL
            $baseUrl = $scheme . '://' . $host;
            if (($scheme === 'http' && $port !== 80) || ($scheme === 'https' && $port !== 443)) {
                $baseUrl .= ':' . $port;
            }
            
            $url = $baseUrl . '/schedule/run';
            $key = config('app.schedule_key', env('SCHEDULE_KEY', 'default-schedule-key-change-me'));
            
            // Use fire-and-forget approach to avoid blocking
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?key=' . $key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100); // 100ms timeout
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For self-signed certs
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            // Silently fail - we don't want to break the site
        }
    }
}