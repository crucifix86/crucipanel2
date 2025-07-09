<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ThemeSelector extends Component
{
    public $currentTheme;
    public $themes;
    public $showModal = false;
    
    public function mount()
    {
        $this->currentTheme = Auth::user()->theme ?? config('themes.default');
        $this->themes = config('themes.themes');
    }
    
    public function selectTheme($theme)
    {
        if (array_key_exists($theme, $this->themes)) {
            $user = Auth::user();
            $user->theme = $theme;
            $user->save();
            
            $this->currentTheme = $theme;
            $this->showModal = false;
            
            // Emit event to update theme immediately
            $this->dispatch('theme-changed', theme: $theme);
            
            // Refresh the page to apply new theme
            return redirect()->back()->with('success', 'Theme updated successfully!');
        }
    }
    
    public function render()
    {
        return view('livewire.theme-selector');
    }
}
