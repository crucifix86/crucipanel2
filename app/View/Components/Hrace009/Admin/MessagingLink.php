<?php

namespace App\View\Components\Hrace009\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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
        if (request()->routeIs('admin.messaging.settings')) {
            $status = 'true';
            $settingsText = '700';
            $settingsLight = 'text-light';
        } else {
            $status = 'false';
            $settingsText = '400';
            $settingsLight = 'text-gray-400';
        }
        
        return view('components.hrace009.admin.messaging-link', [
            'status' => $status,
            'settingsText' => $settingsText,
            'settingsLight' => $settingsLight
        ]);
    }
}
