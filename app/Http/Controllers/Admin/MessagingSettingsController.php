<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessagingSettings;
use Illuminate\Http\Request;

class MessagingSettingsController extends Controller
{
    /**
     * Display the messaging settings
     */
    public function index()
    {
        $settings = MessagingSettings::getSettings();
        
        return view('admin.messaging.settings', compact('settings'));
    }

    /**
     * Update the messaging settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'messaging_enabled' => 'boolean',
            'profile_wall_enabled' => 'boolean',
            'message_rate_limit' => 'required|integer|min:1|max:100',
            'wall_message_rate_limit' => 'required|integer|min:1|max:50',
        ]);

        $settings = MessagingSettings::getSettings();
        $settings->update([
            'messaging_enabled' => $request->has('messaging_enabled'),
            'profile_wall_enabled' => $request->has('profile_wall_enabled'),
            'message_rate_limit' => $request->message_rate_limit,
            'wall_message_rate_limit' => $request->wall_message_rate_limit,
        ]);

        return redirect()->back()->with('success', __('admin.messaging.settings_updated'));
    }
}
