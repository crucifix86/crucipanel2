<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ThemePreference extends Component
{
    public $currentTheme;
    public $themes;
    
    public function mount()
    {
        $this->currentTheme = Auth::user()->theme ?? 'mystical-purple';
        $this->themes = [
            'mystical-purple' => [
                'name' => 'Mystical Purple',
                'description' => 'Epic fantasy theme with mystical purple gradients and floating particles'
            ],
            'dark-gaming' => [
                'name' => 'Dark Gaming',
                'description' => 'Modern dark theme with neon green accents perfect for gaming'
            ]
        ];
    }
    
    public function selectTheme($theme)
    {
        if (array_key_exists($theme, $this->themes)) {
            $user = Auth::user();
            $user->theme = $theme;
            $user->save();
            
            $this->currentTheme = $theme;
            
            session()->flash('success', 'Theme updated successfully!');
            
            // Refresh the page to apply new theme
            return redirect()->back();
        }
    }
    
    public function render()
    {
        return view('livewire.profile.theme-preference');
    }
}