<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SchedulerController extends Controller
{
    /**
     * Show scheduler settings
     */
    public function index()
    {
        $lastRun = Cache::get('schedule:last_run', []);
        $isRunning = Cache::has('schedule:running');
        
        // Check if SCHEDULE_KEY exists (use config, not env)
        $scheduleKey = config('app.schedule_key', env('SCHEDULE_KEY'));
        $hasScheduleKey = !empty($scheduleKey) && $scheduleKey !== 'change-this-to-a-random-string' && $scheduleKey !== 'default-schedule-key-change-me';
        
        // Get last log
        $lastLog = Cache::get('schedule:last_log');
        
        return view('admin.scheduler.index', [
            'enabled' => config('pw-config.scheduler.enabled', true),
            'running' => $isRunning,
            'lastRun' => $lastRun,
            'hasScheduleKey' => $hasScheduleKey,
            'lastLog' => $lastLog
        ]);
    }
    
    /**
     * Update scheduler settings
     */
    public function update(Request $request)
    {
        Config::write('pw-config.scheduler.enabled', $request->has('enabled'));
        
        // Clear and re-cache config
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        
        return redirect()->route('admin.scheduler.index')->with('saved', '1')
            ->setTargetUrl(url()->previous() . '?saved=1');
    }
    
    /**
     * Manually run scheduled tasks
     */
    public function runNow(Request $request)
    {
        try {
            // Run all tasks immediately with output capture
            $output = [];
            $log = [
                'timestamp' => now()->toDateTimeString(),
                'type' => 'manual',
                'tasks' => []
            ];
            
            try {
                Artisan::call('pw:update-transfer');
                $output[] = 'Transfer update: Success';
                $log['tasks']['transfer'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $output[] = 'Transfer update: Failed - ' . $e->getMessage();
                $log['tasks']['transfer'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            try {
                Artisan::call('pw:update-faction');
                $output[] = 'Faction update: Success';
                $log['tasks']['faction'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $output[] = 'Faction update: Failed - ' . $e->getMessage();
                $log['tasks']['faction'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            try {
                Artisan::call('pw:update-players');
                $output[] = 'Players update: Success';
                $log['tasks']['players'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $output[] = 'Players update: Failed - ' . $e->getMessage();
                $log['tasks']['players'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            try {
                Artisan::call('pw:update-territories');
                $output[] = 'Territories update: Success';
                $log['tasks']['territories'] = ['status' => 'success', 'output' => Artisan::output()];
            } catch (\Exception $e) {
                $output[] = 'Territories update: Failed - ' . $e->getMessage();
                $log['tasks']['territories'] = ['status' => 'failed', 'error' => $e->getMessage()];
            }
            
            // Save log
            Cache::put('schedule:last_log', $log, 86400 * 7);
            
            // Update last run times
            $now = now();
            Cache::put('schedule:last_run', [
                'transfer' => $now,
                'rankings' => $now
            ], 86400);
            
            $message = 'Scheduled tasks completed!<br><br>' . implode('<br>', $output);
            return redirect()->route('admin.scheduler.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.scheduler.index')
                ->with('error', 'Error running tasks: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate and save SCHEDULE_KEY
     */
    public function generateKey(Request $request)
    {
        try {
            // Generate a random key
            $key = \Str::random(32);
            
            // Read the .env file
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);
            
            // Check if SCHEDULE_KEY already exists
            if (strpos($envContent, 'SCHEDULE_KEY=') !== false) {
                // Replace existing key
                $envContent = preg_replace('/SCHEDULE_KEY=.*/', 'SCHEDULE_KEY=' . $key, $envContent);
            } else {
                // Add new key after APP_URL
                $envContent = preg_replace('/APP_URL=.*/', '$0' . PHP_EOL . 'SCHEDULE_KEY=' . $key, $envContent);
            }
            
            // Write back to .env
            file_put_contents($envPath, $envContent);
            
            // Clear config cache to pick up new value
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            
            return redirect()->back()
                ->with('success', 'Schedule key generated successfully! The scheduler is now secure.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error generating key: ' . $e->getMessage());
        }
    }
    
    /**
     * Test Arena callback
     */
    public function testArenaCallback(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'userid' => 'required|integer|min:1',
                'logid' => 'required|integer|min:1'
            ]);
            
            // Create a test request to the Arena callback
            $testData = [
                'voted' => 1,
                'userip' => $request->ip(),
                'userid' => $request->userid,
                'logid' => $request->logid,
                'custom' => 'test_from_admin_panel'
            ];
            
            // Call the Arena callback controller directly
            $arenaController = new \App\Http\Controllers\ArenaCallback();
            $mockRequest = new Request($testData);
            $mockRequest->setMethod('POST');
            
            // Execute the callback
            $result = $arenaController->incentive($mockRequest);
            
            return redirect()->route('admin.scheduler.index')
                ->with('success', 'Test callback sent! Result: ' . $result . '<br>Check the Arena Callbacks tab to see the log entry.');
        } catch (\Exception $e) {
            return redirect()->route('admin.scheduler.index')
                ->with('error', 'Error sending test callback: ' . $e->getMessage());
        }
    }
}