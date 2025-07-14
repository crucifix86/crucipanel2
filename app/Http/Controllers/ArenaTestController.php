<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArenaTestController extends Controller
{
    public function test(Request $request)
    {
        // Log to a separate file that doesn't require database
        $logData = [
            'timestamp' => now()->toDateTimeString(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
            'query_params' => $request->query(),
            'post_data' => $request->all(),
            'raw_body' => $request->getContent()
        ];
        
        // Write to a custom log file
        $logFile = storage_path('logs/arena-test-' . date('Y-m-d') . '.log');
        $logLine = json_encode($logData) . PHP_EOL;
        file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
        
        // Also try regular Laravel logging
        try {
            Log::channel('single')->info('Arena Test Callback', $logData);
        } catch (\Exception $e) {
            // Ignore if database is down
        }
        
        return response('OK - Test logged', 200);
    }
}