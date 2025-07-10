<?php

namespace App\View\Components\Hrace009\Admin;

use Illuminate\View\Component;

class PagesLink extends Component
{
    public $status;
    public $createText;
    public $createLight;
    public $viewText;
    public $viewLight;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->status = 'false';
        $this->createText = '400';
        $this->createLight = 'text-gray-400';
        $this->viewText = '400';
        $this->viewLight = 'text-gray-400';

        if (request()->routeIs('admin.pages.create')) {
            $this->status = 'true';
            $this->createText = '700';
            $this->createLight = 'text-light';
        } elseif (request()->routeIs('admin.pages.index') || request()->routeIs('admin.pages.edit')) {
            $this->status = 'true';
            $this->viewText = '700';
            $this->viewLight = 'text-light';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hrace009.admin.pages-link');
    }
}