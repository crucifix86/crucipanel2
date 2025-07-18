<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\MessagingSettings;
use App\Models\WelcomeMessageSetting;
use App\Models\WelcomeMessageReward;
use hrace009\PerfectWorldAPI\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->messaging_enabled) {
            return redirect()->route('HOME')->with('error', __('messages.messaging_disabled'));
        }
        
        $inbox = Auth::user()->receivedMessages()
            ->where('deleted_by_recipient', false)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'inbox_page');

        $outbox = Auth::user()->sentMessages()
            ->where('deleted_by_sender', false)
            ->with('recipient')
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'outbox_page');

        return view('messages.index', compact('inbox', 'outbox'));
    }
    
    public function inbox()
    {
        return redirect()->route('messages.index');
    }

    public function outbox()
    {
        return redirect()->route('messages.index')->with('tab', 'outbox');
    }

    public function compose($userId = null)
    {
        return redirect()->route('messages.index')->with('tab', 'compose')->with('recipient_id', $userId);
    }

    public function store(Request $request)
    {
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->messaging_enabled) {
            return redirect()->route('HOME')->with('error', __('messages.messaging_disabled'));
        }

        // Check rate limit
        $recentMessages = Auth::user()->sentMessages()
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentMessages >= $settings->message_rate_limit) {
            return back()->withInput()->with('error', __('messages.rate_limit_exceeded'));
        }

        $validated = $request->validate([
            'recipient_id' => ['required', 'exists:users,id', Rule::notIn([Auth::id()])],
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:1|max:10000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $validated['recipient_id'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message']
        ]);

        return redirect()->route('messages.index')->with('tab', 'outbox')->with('success', __('messages.sent_successfully'));
    }

    public function show(Message $message)
    {
        // Check if user can view this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if recipient
        if ($message->recipient_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
            
            // Check if this is a welcome message with unclaimed reward
            if ($message->is_welcome_message) {
                $this->claimWelcomeReward($message);
            }
        }

        return view('messages.show', compact('message'));
    }

    public function reply(Message $message)
    {
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->messaging_enabled) {
            return redirect()->route('HOME')->with('error', __('messages.messaging_disabled'));
        }

        // Check if user can reply to this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403);
        }

        $recipient = $message->sender_id === Auth::id() ? $message->recipient : $message->sender;

        return view('messages.reply', compact('message', 'recipient'));
    }

    public function storeReply(Request $request, Message $message)
    {
        $settings = MessagingSettings::first();
        
        if (!$settings || !$settings->messaging_enabled) {
            return redirect()->route('HOME')->with('error', __('messages.messaging_disabled'));
        }

        // Check if user can reply to this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403);
        }

        // Check rate limit
        $recentMessages = Auth::user()->sentMessages()
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentMessages >= $settings->message_rate_limit) {
            return back()->withInput()->with('error', __('messages.rate_limit_exceeded'));
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1|max:10000'
        ]);

        $recipientId = $message->sender_id === Auth::id() ? $message->recipient_id : $message->sender_id;

        $reply = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $recipientId,
            'subject' => 'Re: ' . ($message->subject ?? __('messages.no_subject')),
            'message' => $validated['message'],
            'parent_id' => $message->id
        ]);

        return redirect()->route('messages.index')->with('success', __('messages.reply_sent'));
    }

    public function destroy(Message $message)
    {
        // Check if user can delete this message
        if ($message->sender_id === Auth::id()) {
            $message->update(['deleted_by_sender' => true]);
        } elseif ($message->recipient_id === Auth::id()) {
            $message->update(['deleted_by_recipient' => true]);
        } else {
            abort(403);
        }

        $successMessage = __('messages.deleted_successfully');
        
        if ($message->sender_id === Auth::id()) {
            return redirect()->route('messages.index')->with('tab', 'outbox')->with('success', $successMessage);
        } else {
            return redirect()->route('messages.index')->with('success', $successMessage);
        }
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        
        if (!$search || strlen($search) < 2) {
            return response()->json([]);
        }

        $users = User::where('id', '!=', Auth::id())
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
    
    public function showAjax(Message $message)
    {
        // Check if user can view this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if recipient
        if ($message->recipient_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
            
            // Check if this is a welcome message with unclaimed reward
            if ($message->is_welcome_message) {
                $this->claimWelcomeReward($message);
            }
        }

        $html = view('messages.partials.message', compact('message'))->render();
        
        return response()->json([
            'html' => $html,
            'can_reply' => $message->recipient_id === Auth::id()
        ]);
    }
    
    private function claimWelcomeReward(Message $message)
    {
        // Check if reward already claimed
        $existingReward = WelcomeMessageReward::where('user_id', Auth::id())
            ->where('message_id', $message->id)
            ->first();
            
        if ($existingReward) {
            return;
        }
        
        $settings = WelcomeMessageSetting::first();
        
        if (!$settings || !$settings->reward_enabled || $settings->reward_amount <= 0) {
            return;
        }
        
        DB::beginTransaction();
        
        try {
            // Give reward to user
            $user = Auth::user();
            $api = new API();
            
            switch ($settings->reward_type) {
                case 'virtual':
                    $user->money = $user->money + $settings->reward_amount;
                    $user->save();
                    break;
                case 'cubi':
                    $api->addCubiUser($user->ID, $settings->reward_amount);
                    break;
                case 'bonus':
                    $user->bonuspoint = $user->bonuspoint + $settings->reward_amount;
                    $user->save();
                    break;
            }
            
            // Record the reward
            WelcomeMessageReward::create([
                'user_id' => Auth::id(),
                'message_id' => $message->id,
                'reward_type' => $settings->reward_type,
                'reward_amount' => $settings->reward_amount,
                'claimed_at' => now(),
            ]);
            
            DB::commit();
            
            // Add a flash message for the user
            $rewardText = $settings->reward_amount . ' ';
            switch ($settings->reward_type) {
                case 'virtual':
                    $rewardText .= config('pw-config.currency_name', 'Coins');
                    break;
                case 'cubi':
                    $rewardText .= 'Gold';
                    break;
                case 'bonus':
                    $rewardText .= 'Bonus Points';
                    break;
            }
            
            session()->flash('welcome_reward', "Congratulations! You've received {$rewardText} as a welcome gift!");
            
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}