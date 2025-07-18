<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeMessageSetting;
use Illuminate\Http\Request;

class WelcomeMessageController extends Controller
{
    public function index()
    {
        $settings = WelcomeMessageSetting::firstOrCreate(
            [],
            [
                'enabled' => false,
                'subject' => 'Welcome to ' . config('app.name'),
                'message' => "Welcome to our server!\n\nWe're excited to have you join our community. This message contains a special reward for new players.\n\nTo claim your reward, simply read this message. The reward will be automatically added to your account.\n\nIf you have any questions, feel free to reach out to our support team.\n\nEnjoy your adventure!",
                'reward_enabled' => true,
                'reward_type' => 'virtual',
                'reward_amount' => 1000,
            ]
        );
        return view('admin.welcome-message.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'reward_enabled' => 'required|boolean',
            'reward_type' => 'required|in:virtual,cubi,bonus',
            'reward_amount' => 'required|integer|min:0',
        ]);

        $settings = WelcomeMessageSetting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.welcome-message.index')
            ->with('success', 'Welcome message settings updated successfully!');
    }
}