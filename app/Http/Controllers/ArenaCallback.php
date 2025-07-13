<?php

namespace App\Http\Controllers;

use App\Models\ArenaLogs;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;

class ArenaCallback extends Controller
{
    public function incentive(Request $request)
    {
        // Check database connection first
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            \Log::error('Arena Callback: Database connection failed', [
                'error' => $e->getMessage(),
                'callback_data' => $request->all()
            ]);
            
            // Write to file as fallback
            $fallbackLog = storage_path('logs/arena-callbacks-fallback.log');
            $logEntry = [
                'timestamp' => now()->toIso8601String(),
                'error' => 'Database connection failed',
                'callback_data' => $request->all(),
                'ip' => $request->ip()
            ];
            file_put_contents($fallbackLog, json_encode($logEntry) . PHP_EOL, FILE_APPEND | LOCK_EX);
            
            return 'Database Error - Unable to process vote';
        }
        
        // Log all incoming callback data
        \Log::info('Arena Callback Received', [
            'all_data' => $request->all(),
            'ip' => $request->ip(),
            'url' => $request->fullUrl()
        ]);
        
        // Store in cache for admin panel viewing
        $callbackLog = [
            'timestamp' => now()->toIso8601String(),
            'userid' => $request->get('userid'),
            'logid' => $request->get('logid'),
            'valid' => $request->get('voted'),
            'userip' => $request->get('userip'),
            'custom' => $request->get('custom'),
            'ip' => $request->ip(),
            'result' => 'Processing...'
        ];
        
        // Get existing logs
        $logs = \Cache::get('arena:callback_logs', []);
        
        // Keep only last 50 entries
        if (count($logs) >= 50) {
            array_shift($logs);
        }
        
        $request->validate([
            'voted' => 'integer|required',
            'userip' => 'ip|required',
            'userid' => 'integer|required',
            'logid' => 'integer|required'
        ]);
        $valid = $request->get('voted');
        $userip = $request->get('userip');
        $userid = $request->get('userid');
        $logid = $request->get('logid');
        $custom = $request->get('custom');

        if ($userid && $valid == 1) {
            \Log::info('Arena: Processing vote', ['userid' => $userid, 'logid' => $logid, 'valid' => $valid]);
            
            $logs = ArenaLogs::current($request, $userid, $logid, $valid);
            $reward = $logs->get()->count();
            
            \Log::info('Arena: Found logs', ['count' => $reward]);

            if ($reward) {
                $user = User::whereId($userid)->first();
                \Log::info('Arena: User found', ['user_id' => $user->ID ?? 'not found', 'current_money' => $user->money ?? 0]);
                
                $logs->update([
                    'status' => 0,
                    'ip_address' => $userip
                ]);

                switch (config('arena.reward_type')) {
                    case 'bonuses':  // Fixed typo from 'bonusess'
                        $user->bonuses = $user->bonuses + config('arena.reward');
                        $user->save();
                        \Log::info('Arena: Bonuses added', ['amount' => config('arena.reward'), 'new_total' => $user->bonuses]);
                        break;
                    case 'virtual':
                        $user->money = $user->money + config('arena.reward');
                        $user->save();
                        \Log::info('Arena: Virtual currency added', ['amount' => config('arena.reward'), 'new_total' => $user->money]);
                        break;
                    case 'cubi':
                        Transfer::create([
                            'user_id' => $userid,
                            'zone_id' => 1,
                            'cash' => config('arena.reward')
                        ]);
                        \Log::info('Arena: Cubi transfer created', ['amount' => config('arena.reward')]);
                        break;
                }
                
                // Mark the log as rewarded so we can show notification
                $logs->update([
                    'rewarded_at' => now()
                ]);
                $result = 'OK';
            } else {
                $result = 'No record found';
                \Log::warning('Arena: No record found', ['userid' => $userid, 'logid' => $logid]);
            }
        } else {
            $result = 'Already Voted';
            \Log::warning('Arena: Invalid vote or already voted', ['userid' => $userid, 'valid' => $valid]);
        }
        
        // Update callback log with result
        $callbackLog['result'] = $result;
        $logs[] = $callbackLog;
        \Cache::put('arena:callback_logs', $logs, 86400 * 7); // Keep for 7 days
        
        return $result;
    }
}
