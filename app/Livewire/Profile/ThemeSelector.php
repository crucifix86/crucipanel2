<?php

namespace App\Livewire\Profile;

use App\Models\Theme;
use Livewire\Component;

class ThemeSelector extends Component
{
    public $selectedThemeId;
    public $themes;
    
    public function mount()
    {
        $this->selectedThemeId = auth()->user()->theme_id;
        $this->themes = Theme::getVisibleThemes();
        
        // If user has no theme selected, set to default theme
        if (!$this->selectedThemeId) {
            $defaultTheme = Theme::where('is_default', true)->first();
            if ($defaultTheme) {
                $this->selectedThemeId = $defaultTheme->id;
            }
        }
    }
    
    public function updateTheme()
    {
        $this->validate([
            'selectedThemeId' => 'required|exists:themes,id'
        ]);
        
        // Check if theme is visible
        if ($this->selectedThemeId) {
            $theme = Theme::find($this->selectedThemeId);
            if (!$theme->is_visible) {
                session()->flash('error', 'Selected theme is not available.');
                return;
            }
        }
        
        auth()->user()->update([
            'theme_id' => $this->selectedThemeId
        ]);
        
        // Update session for immediate effect
        if ($this->selectedThemeId) {
            session(['active_theme_id' => $this->selectedThemeId]);
        } else {
            session()->forget('active_theme_id');
        }
        
        session()->flash('message', 'Theme preference updated successfully!');
        
        // Redirect to refresh the theme
        return redirect()->route('profile.show');
    }
    
    public function render()
    {
        return view('livewire.profile.theme-selector');
    }
}
