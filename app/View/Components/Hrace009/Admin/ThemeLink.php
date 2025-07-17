<?php

namespace App\View\Components\Hrace009\Admin;

use Illuminate\View\Component;

class ThemeLink extends Component
{
    public $status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->status = request()->routeIs('admin.themes.*') ? 'true' : 'false';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hrace009.admin.theme-link');
    }
}