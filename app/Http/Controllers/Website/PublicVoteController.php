<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ArenaLogs;
use App\Models\VoteLog;
use App\Models\VoteSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicVoteController extends Controller
{
    public function index(Request $request)
    {
        $vote_info = [];
        $sites = VoteSite::all();

        // Calculate vote cooldowns for authenticated users
        if (Auth::check()) {
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

            // Arena Top 100 cooldown calculation
            $arena_info = [];
            $arena_log = ArenaLogs::onCooldown($request, Auth::user()->ID);
            
            // Check if we should clear timer for testing
            if (config('arena.test_mode_clear_timer')) {
                \Log::info('Arena: Test mode - clearing timer for user ' . Auth::user()->ID . ' (public vote page)');
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
        } else {
            // For guests, show all sites as available but require login
            foreach ($sites as $site) {
                $vote_info[$site->id]['status'] = FALSE;
            }
            $arena_info = [];
        }

        // Check for recently rewarded arena votes
        $arenaVoteSuccess = null;
        if (Auth::check()) {
            $recentReward = ArenaLogs::where('user_id', Auth::user()->ID)
                ->whereNotNull('rewarded_at')
                ->where('rewarded_at', '>', Carbon::now()->subMinutes(5))
                ->where('status', 0)
                ->first();
                
            if ($recentReward) {
                $arenaVoteSuccess = [
                    'reward_amount' => config('arena.reward'),
                    'reward_type' => config('arena.reward_type'),
                    'timestamp' => $recentReward->rewarded_at
                ];
                
                // Mark as seen by setting status to -1
                $recentReward->status = -1;
                $recentReward->save();
            }
        }

        return view('website.vote', [
            'sites' => $sites,
            'vote_info' => $vote_info,
            'arena' => new ArenaLogs(),
            'arena_info' => $arena_info,
            'arena_vote_success' => $arenaVoteSuccess
        ]);
    }
    
    public function redirectToSite(Request $request, VoteSite $site)
    {
        if (!Auth::check()) {
            return redirect()->route('public.vote')->with('error', 'You must be logged in to vote.');
        }
        
        // Store vote attempt in session
        session(['vote_pending_' . $site->id => time()]);
        
        // Redirect to the voting site
        return redirect()->to($site->link);
    }
    
    public function redirectToArena(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('public.vote')->with('error', 'You must be logged in to vote.');
        }
        
        // Check if we should bypass cooldown for testing
        if (config('arena.test_mode_clear_timer')) {
            \Log::info('Arena: Test mode - bypassing cooldown check for user ' . Auth::user()->ID . ' (public vote)');
        }
        
        // Check if user has a completed vote in cooldown period (unless test mode)
        if (!config('arena.test_mode_clear_timer') && ArenaLogs::recent($request, Auth::user()->ID)->exists()) {
            return redirect()->route('public.vote')->with('error', __('vote.already_voted', ['site' => 'Arena Top 100']));
        }
        
        // Create pending log
        $recent = ArenaLogs::create([
            'user_id' => Auth::user()->ID,
            'ip_address' => $request->ip(),
            'reward' => config('arena.reward'),
            'status' => 1  // 1 = pending/not processed, 0 = completed
        ]);
        
        // Store arena vote attempt in session
        session(['vote_pending_arena' => time()]);
        
        // Generate arena callback URL
        $callback_url = urlencode(base64_encode(route('api.arenatop100') . '?userid=' . Auth::user()->ID . '&logid=' . $recent->id));
        
        // If in test mode, simulate immediate callback
        if (config('arena.test_mode')) {
            \Log::info('Arena: Test mode - simulating immediate callback (public vote)');
            // Redirect to our own callback URL to simulate Arena response
            return redirect()->to(route('api.arenatop100') . '?userid=' . Auth::user()->ID . '&logid=' . $recent->id . '&voted=1&userip=' . $request->ip());
        }
        
        // Redirect to arena
        return redirect()->to('https://www.arena-top100.com/index.php?a=in&u=' . config('arena.username') . '&callback=' . $callback_url);
    }
    
    public function checkVoteStatus(Request $request, $siteId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = Auth::user();
        $completed = false;
        
        if ($siteId === 'arena') {
            // Check if arena vote was completed
            $pendingTime = session('vote_pending_arena', 0);
            if ($pendingTime > 0) {
                $recentLog = ArenaLogs::where('user_id', $user->ID)
                    ->where('created_at', '>', Carbon::createFromTimestamp($pendingTime))
                    ->first();
                    
                if ($recentLog) {
                    $completed = true;
                    session()->forget('vote_pending_arena');
                }
            }
        } else {
            // Check if regular vote was completed
            $pendingTime = session('vote_pending_' . $siteId, 0);
            if ($pendingTime > 0) {
                $recentLog = VoteLog::where('user_id', $user->ID)
                    ->where('site_id', $siteId)
                    ->where('created_at', '>', Carbon::createFromTimestamp($pendingTime))
                    ->first();
                    
                if ($recentLog) {
                    $completed = true;
                    session()->forget('vote_pending_' . $siteId);
                }
            }
        }
        
        // Get updated balance
        $user->refresh();
        
        return response()->json([
            'completed' => $completed,
            'new_balance' => [
                'money' => $user->money,
                'bonuses' => $user->bonuses
            ],
            'currency_name' => config('pw-config.currency_name', 'Coins')
        ]);
    }
}