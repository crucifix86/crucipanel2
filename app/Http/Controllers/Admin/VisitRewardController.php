<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitRewardSetting;
use Illuminate\Http\Request;

class VisitRewardController extends Controller
{
    public function index()
    {
        $settings = VisitRewardSetting::first();
        
        if (!$settings) {
            $settings = VisitRewardSetting::create([
                'enabled' => false,
                'title' => 'Visit Reward',
                'description' => 'Get rewards for visiting!',
                'reward_type' => 'bonuses',
                'reward_amount' => 10,
                'cooldown_hours' => 24
            ]);
        }
        
        return view('admin.visit-reward.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reward_amount' => 'required|integer|min:1',
            'reward_type' => 'required|in:virtual,cubi,bonuses',
            'cooldown_hours' => 'required|integer|min:1'
        ]);
        
        $settings = VisitRewardSetting::firstOrNew();
        
        $settings->enabled = $request->has('enabled');
        $settings->title = $request->title;
        $settings->description = $request->description;
        $settings->reward_amount = $request->reward_amount;
        $settings->reward_type = $request->reward_type;
        $settings->cooldown_hours = $request->cooldown_hours;
        
        $settings->save();
        
        // Clear config cache
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        
        // Redirect with success parameter
        return redirect()->route('admin.visit-reward.settings', ['saved' => 1]);
    }
}
