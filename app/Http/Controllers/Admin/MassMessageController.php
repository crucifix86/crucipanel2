<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MassMessageController extends Controller
{
    public function index()
    {
        return view('admin.mass-message.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,active,role',
            'role' => 'required_if:recipient_type,role|in:admin,gamemaster,player',
        ]);

        DB::beginTransaction();
        
        try {
            // Get recipients based on type
            $query = User::query();
            
            switch ($request->recipient_type) {
                case 'active':
                    // Get users who logged in within last 30 days
                    $query->where('last_login', '>=', now()->subDays(30));
                    break;
                case 'role':
                    if ($request->role === 'admin') {
                        $query->where('role', 'administrator');
                    } elseif ($request->role === 'gamemaster') {
                        $query->where('role', 'gamemaster');
                    } else {
                        $query->where('role', 'player');
                    }
                    break;
                // 'all' requires no additional filtering
            }
            
            $recipients = $query->get();
            $senderId = Auth::id();
            $messageCount = 0;
            
            // Add [Admin Message] prefix to subject
            $subject = '[Admin Message] ' . $request->subject;
            
            foreach ($recipients as $recipient) {
                // Don't send to self
                if ($recipient->ID === $senderId) {
                    continue;
                }
                
                Message::create([
                    'sender_id' => $senderId,
                    'recipient_id' => $recipient->ID,
                    'subject' => $subject,
                    'message' => $request->message,
                    'is_read' => false,
                ]);
                
                $messageCount++;
            }
            
            DB::commit();
            
            return redirect()->route('admin.mass-message.index')
                ->with('success', "Message sent successfully to {$messageCount} users!");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to send messages: ' . $e->getMessage());
        }
    }
}