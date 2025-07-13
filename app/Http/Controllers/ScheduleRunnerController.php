<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ScheduleRunnerController extends Controller
{
    /**
     * Run scheduled tasks via web request
     * This eliminates the need for system cron jobs
     */
    public function run(Request $request)
    {
        // Security check - only allow from local requests or with valid key
        $validKey = config('app.schedule_key', 'default-schedule-key-change-me');
        
        if (!$request->isLocal() && $request->input('key') !== $validKey) {
            abort(403, 'Unauthorized');
        }
        
        // Check if scheduler is enabled
        if (!config('pw-config.scheduler.enabled', true)) {
            return response()->json(['status' => 'disabled']);
        }
        
        // Prevent overlapping runs
        $lockKey = 'schedule:running';
        if (Cache::has($lockKey)) {
            return response()->json(['status' => 'already_running']);
        }
        
        // Lock for 5 minutes
        Cache::put($lockKey, true, 300);
        
        try {
            // Run scheduled tasks based on time
            $this->runDueTasks();
            
            Cache::forget($lockKey);
            return response()->json(['status' => 'success', 'time' => now()->toDateTimeString()]);
            
        } catch (\Exception $e) {
            Cache::forget($lockKey);
            Log::error('Schedule runner error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * Run tasks that are due
     */
    protected function runDueTasks()
    {
        $lastRun = Cache::get('schedule:last_run', []);
        $now = now();
        
        // Update transfers - every minute
        if (!isset($lastRun['transfer']) || $now->diffInMinutes($lastRun['transfer']) >= 1) {
            Artisan::call('pw:update-transfer');
            $lastRun['transfer'] = $now;
        }
        
        // Update rankings - hourly
        if (!isset($lastRun['rankings']) || $now->diffInMinutes($lastRun['rankings']) >= 60) {
            Artisan::call('pw:update-faction');
            Artisan::call('pw:update-players');
            Artisan::call('pw:update-territories');
            $lastRun['rankings'] = $now;
        }
        
        Cache::put('schedule:last_run', $lastRun, 86400); // Store for 24 hours
    }
    
    /**
     * Get scheduler status
     */
    public function status()
    {
        $lastRun = Cache::get('schedule:last_run', []);
        $isRunning = Cache::has('schedule:running');
        
        return response()->json([
            'enabled' => config('pw-config.scheduler.enabled', true),
            'running' => $isRunning,
            'last_run' => $lastRun,
            'tasks' => [
                'transfer' => 'Every minute',
                'rankings' => 'Every hour'
            ]
        ]);
    }
}