<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class PinSettings extends Component
{
    use PasswordValidationRules;

    public $state = [];
    public $pinEnabled = false;

    public function mount()
    {
        $this->pinEnabled = auth()->user()->pin_enabled;
    }

    public function updatePinSettings()
    {
        $user = auth()->user();
        
        // Update PIN enabled status
        $user->pin_enabled = $this->pinEnabled;
        
        if ($this->pinEnabled && (isset($this->state['pin']) && $this->state['pin'])) {
            // If enabling PIN or updating PIN
            $rules = [
                'pin' => $this->UpdateUserPinPagePinConfirmRules(),
            ];
            
            // If user already has a PIN, require current PIN
            if ($user->qq) {
                $rules['current_pin'] = ['required', function ($attribute, $value, $fail) use ($user) {
                    if ($value !== $user->qq) {
                        $fail(__('The current PIN is incorrect.'));
                    }
                }];
            }
            
            Validator::make($this->state, $rules)->validateWithBag('updatePinSettings');
            
            // Update the PIN
            $user->qq = $this->state['pin'];
        } elseif (!$this->pinEnabled) {
            // If disabling PIN, clear it
            $user->qq = null;
        }
        
        $user->save();
        
        $this->dispatch('saved');
        
        // Clear the form
        $this->state = [];
    }

    public function render()
    {
        return view('livewire.profile.pin-settings');
    }
}