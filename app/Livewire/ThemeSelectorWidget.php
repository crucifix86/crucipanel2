<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ThemeSelectorWidget extends Component
{
    public $currentTheme;
    public $themes;
    
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
            
            // Refresh the page to apply new theme
            return redirect()->back()->with('success', 'Theme updated successfully!');
        }
    }
    
    public function render()
    {
        return view('livewire.theme-selector-widget');
    }
}