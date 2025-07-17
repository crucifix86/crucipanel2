<?php

namespace App\Http\Controllers;

use App\Models\ProfileMessage;
use App\Models\User;
use App\Models\MessagingSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(User $user)
    {
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->profile_wall_enabled) {
            return response()->json(['messages' => [], 'enabled' => false]);
        }

        $messages = $user->profileMessages()
            ->visible()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'messages' => $messages,
            'enabled' => true,
            'can_post' => Auth::check()
        ]);
    }

    public function store(Request $request, $username)
    {
        $user = User::where('name', $username)->firstOrFail();
        
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->profile_wall_enabled) {
            flash(__('messages.wall_disabled'))->error();
            return back();
        }

        if (Auth::id() === $user->id) {
            flash(__('messages.cannot_post_own_wall'))->error();
            return back();
        }

        // Check rate limit
        $recentMessages = Auth::user()->sentProfileMessages()
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentMessages >= $settings->wall_message_rate_limit) {
            flash(__('messages.wall_rate_limit'))->error();
            return back();
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1|max:500'
        ]);

        ProfileMessage::create([
            'profile_user_id' => $user->id,
            'sender_id' => Auth::id(),
            'message' => $validated['message']
        ]);

        flash(__('messages.wall_post_success'))->success();
        return back();
    }

    public function destroy(ProfileMessage $profileMessage)
    {
        // Users can delete messages on their own wall or messages they posted
        if ($profileMessage->profile_user_id !== Auth::id() && $profileMessage->sender_id !== Auth::id()) {
            abort(403);
        }

        $profileMessage->delete();

        flash(__('messages.wall_post_deleted'))->success();
        return back();
    }

    public function hide(ProfileMessage $profileMessage)
    {
        // Only the profile owner can hide messages
        if ($profileMessage->profile_user_id !== Auth::id()) {
            abort(403);
        }

        $profileMessage->update(['is_visible' => false]);

        return response()->json(['success' => true]);
    }
}