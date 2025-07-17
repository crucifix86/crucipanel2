<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MessagingSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('name', $username)->with('profile')->firstOrFail();
        $profile = $user->profile;
        
        // Create default profile if it doesn't exist (enabled by default for everyone)
        if (!$profile) {
            $profile = $user->profile()->create([
                'public_profile_enabled' => true,
                'public_wall_enabled' => true,
            ]);
        }
        
        // Get messaging settings
        $messagingSettings = MessagingSettings::first();
        $wallEnabled = $profile && $profile->public_wall_enabled && $messagingSettings && $messagingSettings->profile_wall_enabled;
        
        // Get wall messages if enabled
        $wallMessages = [];
        if ($wallEnabled) {
            $wallMessages = $user->profileMessages()
                ->visible()
                ->with('sender')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
        
        // Get user's characters
        $characters = $user->roles();
        
        return view('public.profile', compact('user', 'wallEnabled', 'wallMessages', 'characters', 'messagingSettings'));
    }
}