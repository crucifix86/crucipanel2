<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdatePublicProfile extends Component
{
    public $public_bio;
    public $public_discord;
    public $public_website;
    public $public_profile_enabled;
    public $public_wall_enabled;

    protected $rules = [
        'public_bio' => 'nullable|string|max:1000',
        'public_discord' => 'nullable|string|max:100',
        'public_website' => 'nullable|url|max:255',
        'public_profile_enabled' => 'boolean',
        'public_wall_enabled' => 'boolean',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->public_bio = $user->public_bio;
        $this->public_discord = $user->public_discord;
        $this->public_website = $user->public_website;
        $this->public_profile_enabled = $user->public_profile_enabled;
        $this->public_wall_enabled = $user->public_wall_enabled;
    }

    public function updatePublicProfile()
    {
        $this->validate();

        Auth::user()->update([
            'public_bio' => $this->public_bio,
            'public_discord' => $this->public_discord,
            'public_website' => $this->public_website,
            'public_profile_enabled' => $this->public_profile_enabled,
            'public_wall_enabled' => $this->public_wall_enabled,
        ]);

        $this->dispatch('saved');
        $this->dispatch('profileUpdated');
    }

    public function render()
    {
        return view('livewire.profile.update-public-profile');
    }
}