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
            if ($arena_log->exists()) {
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

        return view('website.vote', [
            'sites' => $sites,
            'vote_info' => $vote_info,
            'arena' => new ArenaLogs(),
            'arena_info' => $arena_info
        ]);
    }
}