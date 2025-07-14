<?php

namespace App\View\Components\Hrace009\Admin;

use Illuminate\View\Component;

class VisitRewardLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (request()->routeIs('admin.visit-reward.settings')) {
            $status = 'true';
            $textSettings = '700';
            $lightSettings = 'text-light';
        } else {
            $status = 'false';
            $textSettings = '400';
            $lightSettings = 'text-gray-400';
        }
        return view('components.hrace009.admin.visit-reward-link', [
            'status' => $status,
            'textSettings' => $textSettings,
            'lightSettings' => $lightSettings
        ]);
    }
}