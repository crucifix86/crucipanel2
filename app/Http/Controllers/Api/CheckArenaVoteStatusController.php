<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArenaLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckArenaVoteStatusController extends Controller
{
    public function checkStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = Auth::user();
        
        // Check for recently completed Arena votes (within last 5 minutes)
        $recentVote = ArenaLogs::where('user_id', $user->ID)
            ->where('status', 0) // Completed status
            ->where('rewarded_at', '>', now()->subMinutes(5))
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($recentVote) {
            // Get fresh user data for updated balance
            $user->refresh();
            
            return response()->json([
                'completed' => true,
                'reward_amount' => $recentVote->reward,
                'reward_type' => config('arena.reward_type') === 'virtual' ? config('pw-config.currency_name', 'Coins') : 
                               (config('arena.reward_type') === 'cubi' ? 'Gold' : 'Bonus Points'),
                'new_balance' => [
                    'money' => $user->money,
                    'bonuses' => $user->bonuses
                ]
            ]);
        }
        
        return response()->json(['completed' => false]);
    }
}