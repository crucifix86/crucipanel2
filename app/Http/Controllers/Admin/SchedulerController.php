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
        
        return view('admin.scheduler.index', [
            'enabled' => config('pw-config.scheduler.enabled', true),
            'running' => $isRunning,
            'lastRun' => $lastRun
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
            // Run all tasks immediately
            Artisan::call('pw:update-transfer');
            Artisan::call('pw:update-faction');
            Artisan::call('pw:update-players');
            Artisan::call('pw:update-territories');
            
            // Update last run times
            $now = now();
            Cache::put('schedule:last_run', [
                'transfer' => $now,
                'rankings' => $now
            ], 86400);
            
            return redirect()->route('admin.scheduler.index')
                ->with('success', 'All scheduled tasks have been run successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.scheduler.index')
                ->with('error', 'Error running tasks: ' . $e->getMessage());
        }
    }
}