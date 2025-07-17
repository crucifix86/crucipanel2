<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LanguagePreference extends Component
{
    public $language;
    
    public function mount()
    {
        $this->language = Auth::user()->language ?? 'en';
    }
    
    public function updateLanguage()
    {
        $this->validate([
            'language' => 'required|in:en,id'
        ]);
        
        $user = Auth::user();
        $user->language = $this->language;
        $user->save();
        
        // Update current session
        session(['locale' => $this->language]);
        
        // Emit event to show success message
        $this->dispatch('saved');
        
        // Redirect to refresh the page with new language
        return redirect()->route('profile.show');
    }
    
    public function render()
    {
        return view('livewire.profile.language-preference');
    }
}
