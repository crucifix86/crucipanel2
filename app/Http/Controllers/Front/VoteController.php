<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ArenaLogs;
use App\Models\Transfer;
use App\Models\VoteLog;
use App\Models\VoteSite;
use App\Models\VoteSecuritySetting;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function getIndex(Request $request)
    {
        $vote_info = [];
        $sites = VoteSite::all();

        foreach ($sites as $site) {
            $log = VoteLog::onCooldown($request, $site->id);

            if ($log->exists()) {
                $log = $log->first();
                if (time() < ($log->created_at->getTimestamp() + (3600 * $site->hour_limit))) {
                    $vote_info[$site->id]['end_time'] = $log->created_at->addHours($site->hour_limit)->getTimestamp() - Carbon::now()->getTimestamp();
                    $vote_info[$site->id]['status'] = FALSE;
                } else {
                    $vote_info[$site->id]['status'] = TRUE;
                }
            } else {
                $vote_info[$site->id]['status'] = TRUE;
            }
        }

        $arena_info = [];
        $arena_log = ArenaLogs::onCooldown($request, Auth::user()->ID);
        
        // Debug logging
        \Log::info('Arena Vote Check', [
            'user_id' => Auth::user()->ID,
            'test_mode' => config('arena.test_mode'),
            'test_mode_clear_timer' => config('arena.test_mode_clear_timer'),
            'has_cooldown_log' => $arena_log->exists()
        ]);
        
        // Check if we should clear timer for testing
        if (config('arena.test_mode_clear_timer')) {
            \Log::info('Arena: Test mode - clearing timer for user ' . Auth::user()->ID);
            $arena_info[Auth::user()->ID]['status'] = TRUE;
        } else if ($arena_log->exists()) {
            $arena_log = $arena_log->first();
            if (time() < $arena_log->created_at->getTimestamp() + (3600 * config('arena.time'))) {
                $arena_info[Auth::user()->ID]['end_time'] = $arena_log->created_at->addHours(config('arena.time'))->getTimestamp() - Carbon::now()->getTimestamp();
                $arena_info[Auth::user()->ID]['status'] = FALSE;
            } else {
                $arena_info[Auth::user()->ID]['status'] = TRUE;
            }
        } else {
            $arena_info[Auth::user()->ID]['status'] = TRUE;
        }

        return view('front.vote.index', [
            'sites' => $sites,
            'vote_info' => $vote_info,
            'arena' => new ArenaLogs(),
            'arena_info' => $arena_info
        ]);
    }

    public function getSuccess(VoteSite $site)
    {
        return view('front.vote.success', [
            'site' => $site,
        ]);
    }

    public function postCheck(VoteSite $site)
    {
        return redirect()->route('app.vote.success', $site->id);
    }

    public function postSubmit(Request $request, VoteSite $site)
    {
        $settings = VoteSecuritySetting::getSettings();
        $bypass = VoteSecuritySetting::shouldBypass();
        
        // Check IP limits (unless in test mode)
        if (!$bypass) {
            // Check daily IP limit
            if (VoteLog::ipReachedDailyLimit($request->ip())) {
                $message = 'Daily vote limit reached for this IP address. Maximum ' . $settings->max_votes_per_ip_daily . ' votes per day allowed.';
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return redirect()->route('app.vote.index')->with('error', $message);
            }
            
            // Check per-site IP limit
            if (VoteLog::ipReachedSiteLimit($request->ip(), $site->id)) {
                $message = 'Vote limit reached for this site from your IP address today.';
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return redirect()->route('app.vote.index')->with('error', $message);
            }
            
            // Check account restrictions
            if ($settings->account_restrictions_enabled) {
                $user = Auth::user();
                
                // Check email verification
                if ($settings->require_email_verified && !$user->hasVerifiedEmail()) {
                    $message = 'Email verification required to vote. Please verify your email address.';
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => $message]);
                    }
                    return redirect()->route('app.vote.index')->with('error', $message);
                }
                
                // Check account age
                if ($settings->min_account_age_days > 0) {
                    $accountAge = Carbon::parse($user->created_at)->diffInDays(Carbon::now());
                    if ($accountAge < $settings->min_account_age_days) {
                        $message = 'Account must be at least ' . $settings->min_account_age_days . ' days old to vote. Your account is ' . $accountAge . ' days old.';
                        
                        if ($request->ajax() || $request->wantsJson()) {
                            return response()->json(['success' => false, 'message' => $message]);
                        }
                        return redirect()->route('app.vote.index')->with('error', $message);
                    }
                }
                
                // Check character level (if implemented)
                if ($settings->min_character_level > 0) {
                    // Get highest level character for this account
                    $highestLevel = Player::where('userid', $user->ID)
                        ->where('level', '>=', $settings->min_character_level)
                        ->exists();
                    
                    if (!$highestLevel) {
                        $message = 'You need at least one character of level ' . $settings->min_character_level . ' or higher to vote.';
                        
                        if ($request->ajax() || $request->wantsJson()) {
                            return response()->json(['success' => false, 'message' => $message]);
                        }
                        return redirect()->route('app.vote.index')->with('error', $message);
                    }
                }
            }
        }
        
        // Original voting logic continues here
        if (!VoteLog::recent($request, $site)->exists()) {
            switch ($site->type) {
                case 'virtual':
                    $user = Auth::user();
                    $user->money = $site->reward_amount + $user->money;
                    $user->save();
                    break;

                case 'cubi':
                    Transfer::create([
                        'user_id' => Auth::user()->ID,
                        'zone_id' => 1,
                        'cash' => $site->reward_amount
                    ]);
                    break;

                case 'bonuses':
                    $user = Auth::user();
                    $user->bonuses = $site->reward_amount + $user->bonuses;
                    $user->save();
                    break;
            }
            VoteLog::create([
                'user_id' => Auth::user()->ID,
                'ip_address' => $request->ip(),
                'reward' => $site->reward_amount,
                'site_id' => $site->id
            ]);
            
            // If this is an AJAX request from public vote page
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vote rewards claimed successfully!'
                ]);
            }
            
            // If this is from the public vote page, store in session
            if ($request->has('public_vote')) {
                session(['vote_completed_' . $site->id => true]);
            }
            
            return redirect()->to($site->link);
        } else {
            // If this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('vote.already_voted', ['site' => $site->name])
                ]);
            }
            
            return redirect()->route('app.vote.index')->with('error', __('vote.already_voted', ['site' => $site->name]));
        }
    }

    public function arenaSubmit(Request $request)
    {
        $settings = VoteSecuritySetting::getSettings();
        $bypass = VoteSecuritySetting::shouldBypass();
        
        // Check if we should bypass cooldown for testing
        if (config('arena.test_mode_clear_timer')) {
            \Log::info('Arena: Test mode - bypassing cooldown check for user ' . Auth::user()->ID);
        }
        
        // Check IP limits for Arena voting (unless in test mode)
        if (!$bypass) {
            // Check daily IP limit (Arena counts towards daily limit)
            if (VoteLog::ipReachedDailyLimit($request->ip())) {
                $message = 'Daily vote limit reached for this IP address. Maximum ' . $settings->max_votes_per_ip_daily . ' votes per day allowed.';
                return redirect()->route('app.vote.index')->with('error', $message);
            }
            
            // Check account restrictions
            if ($settings->account_restrictions_enabled) {
                $user = Auth::user();
                
                // Check email verification
                if ($settings->require_email_verified && !$user->hasVerifiedEmail()) {
                    return redirect()->route('app.vote.index')->with('error', 'Email verification required to vote. Please verify your email address.');
                }
                
                // Check account age
                if ($settings->min_account_age_days > 0) {
                    $accountAge = Carbon::parse($user->created_at)->diffInDays(Carbon::now());
                    if ($accountAge < $settings->min_account_age_days) {
                        return redirect()->route('app.vote.index')->with('error', 'Account must be at least ' . $settings->min_account_age_days . ' days old to vote.');
                    }
                }
                
                // Check character level
                if ($settings->min_character_level > 0) {
                    $highestLevel = Player::where('userid', $user->ID)
                        ->where('level', '>=', $settings->min_character_level)
                        ->exists();
                    
                    if (!$highestLevel) {
                        return redirect()->route('app.vote.index')->with('error', 'You need at least one character of level ' . $settings->min_character_level . ' or higher to vote.');
                    }
                }
            }
        }
        
        // Check if user has a completed vote in cooldown period
        if (config('arena.test_mode_clear_timer') || !ArenaLogs::recent($request, Auth::user()->ID)->exists()) {
            $recent = ArenaLogs::create([
                'user_id' => Auth::user()->ID,
                'ip_address' => $request->ip(),
                'reward' => config('arena.reward'),
                'status' => 1  // 1 = pending/not processed, 0 = completed
            ]);
            $callback_url = urlencode(base64_encode(route('api.arenatop100') . '?userid=' . Auth::user()->ID . '&logid=' . $recent->id));
            
            // If in test mode, simulate immediate callback
            if (config('arena.test_mode')) {
                \Log::info('Arena: Test mode - simulating immediate callback');
                
                // Simulate the callback directly without redirect
                $callbackController = new \App\Http\Controllers\ArenaCallback();
                $fakeRequest = new \Illuminate\Http\Request([
                    'voted' => 1,
                    'userip' => $request->ip(),
                    'userid' => Auth::user()->ID,
                    'logid' => $recent->id
                ]);
                
                // Process the simulated callback
                $callbackController->incentive($fakeRequest);
                
                // Return to vote page with success message
                return redirect()->route('app.vote.index')->with('success', 'Arena Top 100 vote simulated successfully! Check your balance.');
            }
            
            return redirect()->to('https://www.arena-top100.com/index.php?a=in&u=' . config('arena.username') . '&callback=' . $callback_url);
        } else {
            return redirect()->route('app.vote.index')->with('error', __('vote.already_voted', ['site' => 'Arena Top 100']));
        }
    }
    
    public function clearArenaLogs(Request $request)
    {
        // Only allow in test mode and for admins
        if (!config('arena.test_mode_clear_timer') || !auth()->user()->permission || !auth()->user()->permission->is_admin) {
            return redirect()->route('app.vote.index')->with('error', 'Not authorized');
        }
        
        // Clear all Arena logs for the current user
        ArenaLogs::where('user_id', Auth::user()->ID)->delete();
        
        \Log::info('Arena: Cleared all logs for testing', [
            'user_id' => Auth::user()->ID,
            'cleared_by' => auth()->user()->name
        ]);
        
        return redirect()->route('app.vote.index')->with('success', 'Arena logs cleared for testing');
    }
}
