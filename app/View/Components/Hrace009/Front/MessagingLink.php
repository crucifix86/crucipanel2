<?php

namespace App\View\Components\Hrace009\Front;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class MessagingLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $unreadCount = 0;
        
        if (Auth::check()) {
            $unreadCount = Auth::user()->unread_message_count;
        }
        
        if (request()->routeIs('messages.*')) {
            $status = 'true';
        } else {
            $status = 'false';
        }
        
        return view('components.hrace009.front.messaging-link', [
            'status' => $status,
            'unreadCount' => $unreadCount
        ]);
    }
}