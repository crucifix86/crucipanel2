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
        
        // Check if we're in test mode
        if (config('arena.test_mode')) {
            \Log::warning('Arena: TEST MODE ACTIVE - Always returning successful vote');
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
        
        // Override vote status if in test mode
        if (config('arena.test_mode')) {
            $valid = 1; // Force successful vote
            \Log::info('Arena: Test mode - forcing valid = 1');
        }

        if ($userid && $valid == 1) {
            \Log::info('Arena: Processing vote', ['userid' => $userid, 'logid' => $logid, 'valid' => $valid]);
            
            $logsQuery = ArenaLogs::current($request, $userid, $logid, $valid);
            $logRecord = $logsQuery->first();
            
            \Log::info('Arena: Found log record', ['found' => $logRecord ? 'yes' : 'no']);

            if ($logRecord) {
                $user = User::whereId($userid)->first();
                \Log::info('Arena: User found', ['user_id' => $user->ID ?? 'not found', 'current_money' => $user->money ?? 0]);
                
                $logRecord->update([
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
                $logRecord->update([
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
            
            // If Arena says already voted, we should still update our timer
            // This handles cases where previous callbacks failed
            if ($userid && $valid == 0) {
                // Check if we have a pending log for this user
                $pendingLog = ArenaLogs::where('user_id', $userid)
                    ->where('status', 1) // Pending status
                    ->orderBy('created_at', 'desc')
                    ->first();
                    
                if ($pendingLog) {
                    // Update it to completed so timer shows correctly
                    $pendingLog->update([
                        'status' => 0,
                        'ip_address' => $userip
                    ]);
                    \Log::info('Arena: Updated pending log to show cooldown', ['userid' => $userid]);
                } else {
                    // Create a completed log to sync with Arena's cooldown
                    ArenaLogs::create([
                        'user_id' => $userid,
                        'ip_address' => $userip,
                        'reward' => 0, // No reward since they already voted
                        'status' => 0  // Mark as completed to show timer
                    ]);
                    \Log::info('Arena: Created cooldown log to sync with Arena', ['userid' => $userid]);
                }
            }
        }
        
        // Update callback log with result
        $callbackLog['result'] = $result;
        $logs[] = $callbackLog;
        \Cache::put('arena:callback_logs', $logs, 86400 * 7); // Keep for 7 days
        
        return $result;
    }
}
