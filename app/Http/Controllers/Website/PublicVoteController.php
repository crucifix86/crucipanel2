<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\VoteSite;
use App\Models\VoteLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicVoteController extends Controller
{
    public function index(Request $request)
    {
        // Get all active vote sites
        $sites = VoteSite::all();
        $vote_info = [];
        
        // Check cooldowns for authenticated users
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
        }
        
        return view('website.vote', [
            'sites' => $sites,
            'vote_info' => $vote_info
        ]);
    }
}