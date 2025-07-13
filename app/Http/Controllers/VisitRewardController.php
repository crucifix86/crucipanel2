<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\VisitRewardLog;
use App\Models\VisitRewardSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitRewardController extends Controller
{
    public function claim(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $settings = VisitRewardSetting::first();
        
        if (!$settings || !$settings->enabled) {
            return response()->json(['error' => 'Visit rewards are disabled'], 400);
        }
        
        $user = Auth::user();
        
        // Check if user can claim
        $canClaim = VisitRewardLog::canClaim($request, $user->ID, $settings->cooldown_hours);
        
        if (!$canClaim) {
            $lastClaim = VisitRewardLog::lastClaim($user->ID);
            $nextClaimTime = $lastClaim->created_at->addHours($settings->cooldown_hours);
            
            return response()->json([
                'error' => 'Already claimed',
                'next_claim_at' => $nextClaimTime->toIso8601String(),
                'seconds_until_next' => $nextClaimTime->diffInSeconds(Carbon::now())
            ], 400);
        }
        
        // Give reward
        switch ($settings->reward_type) {
            case 'bonuses':
                $user->bonuses = $user->bonuses + $settings->reward_amount;
                $user->save();
                break;
                
            case 'virtual':
                $user->money = $user->money + $settings->reward_amount;
                $user->save();
                break;
                
            case 'cubi':
                Transfer::create([
                    'user_id' => $user->ID,
                    'zone_id' => 1,
                    'cash' => $settings->reward_amount
                ]);
                break;
        }
        
        // Log the claim
        VisitRewardLog::create([
            'user_id' => $user->ID,
            'ip_address' => $request->ip(),
            'reward_amount' => $settings->reward_amount,
            'reward_type' => $settings->reward_type
        ]);
        
        // Get next claim time
        $nextClaimTime = Carbon::now()->addHours($settings->cooldown_hours);
        
        return response()->json([
            'success' => true,
            'reward_amount' => $settings->reward_amount,
            'reward_type' => $settings->reward_type,
            'next_claim_at' => $nextClaimTime->toIso8601String(),
            'seconds_until_next' => $nextClaimTime->diffInSeconds(Carbon::now()),
            'new_balance' => [
                'money' => $user->fresh()->money,
                'bonuses' => $user->fresh()->bonuses
            ]
        ]);
    }
    
    public function status(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $settings = VisitRewardSetting::first();
        
        if (!$settings || !$settings->enabled) {
            return response()->json(['enabled' => false], 200);
        }
        
        $user = Auth::user();
        $lastClaim = VisitRewardLog::lastClaim($user->ID);
        
        if (!$lastClaim) {
            // Never claimed before, can claim now
            return response()->json([
                'enabled' => true,
                'can_claim' => true,
                'title' => $settings->title,
                'description' => $settings->description,
                'reward_amount' => $settings->reward_amount,
                'reward_type' => $settings->reward_type,
                'cooldown_hours' => $settings->cooldown_hours
            ]);
        }
        
        $nextClaimTime = $lastClaim->created_at->addHours($settings->cooldown_hours);
        $canClaim = Carbon::now()->gte($nextClaimTime);
        
        return response()->json([
            'enabled' => true,
            'can_claim' => $canClaim,
            'title' => $settings->title,
            'description' => $settings->description,
            'reward_amount' => $settings->reward_amount,
            'reward_type' => $settings->reward_type,
            'cooldown_hours' => $settings->cooldown_hours,
            'last_claim_at' => $lastClaim->created_at->toIso8601String(),
            'next_claim_at' => $nextClaimTime->toIso8601String(),
            'seconds_until_next' => $canClaim ? 0 : $nextClaimTime->diffInSeconds(Carbon::now())
        ]);
    }
}
