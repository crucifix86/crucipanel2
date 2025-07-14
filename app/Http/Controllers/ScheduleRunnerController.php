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
        // Security check - only allow with valid key
        $validKey = config('app.schedule_key', env('SCHEDULE_KEY', 'default-schedule-key-change-me'));
        
        // Always require a valid key (remove isLocal check which uses APP_URL)
        if ($request->input('key') !== $validKey || $validKey === 'default-schedule-key-change-me') {
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
        $log = [
            'timestamp' => $now->toDateTimeString(),
            'type' => 'automatic',
            'tasks' => []
        ];
        
        // Update transfers - every minute
        if (!isset($lastRun['transfer']) || $now->diffInMinutes($lastRun['transfer']) >= 1) {
            try {
                Artisan::call('pw:update-transfer');
                $log['tasks']['transfer'] = ['status' => 'success', 'output' => Artisan::output()];
                $lastRun['transfer'] = $now;
            } catch (\Exception $e) {
                $log['tasks']['transfer'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
        }
        
        // Update rankings - hourly
        if (!isset($lastRun['rankings']) || $now->diffInMinutes($lastRun['rankings']) >= 60) {
            try {
                Artisan::call('pw:update-faction');
                $log['tasks']['faction'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $log['tasks']['faction'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            try {
                Artisan::call('pw:update-players');
                $log['tasks']['players'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $log['tasks']['players'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            try {
                Artisan::call('pw:update-territories');
                $log['tasks']['territories'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $log['tasks']['territories'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            $lastRun['rankings'] = $now;
        }
        
        // Save log (only keep last run)
        if (!empty($log['tasks'])) {
            Cache::put('schedule:last_log', $log, 86400 * 7); // Keep for 7 days
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