<?php

namespace App\Livewire\Hrace009\Admin;

use App\Models\SocialLink;
use Livewire\Component;
use Livewire\Attributes\On;

class SocialLinksManager extends Component
{
    public $socialLinks;
    public $editingId = null;
    public $editingPlatform = '';
    public $editingUrl = '';
    public $editingIcon = '';
    
    public function mount()
    {
        $this->loadLinks();
    }
    
    public function loadLinks()
    {
        $this->socialLinks = SocialLink::orderBy('order')->get();
    }
    
    #[On('social-link-added')]
    public function refreshLinks()
    {
        $this->loadLinks();
    }
    
    public function startEdit($id)
    {
        $link = SocialLink::find($id);
        if ($link) {
            $this->editingId = $id;
            $this->editingPlatform = $link->platform;
            $this->editingUrl = $link->url;
            $this->editingIcon = $link->icon;
        }
    }
    
    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editingPlatform = '';
        $this->editingUrl = '';
        $this->editingIcon = '';
    }
    
    public function update()
    {
        $this->validate([
            'editingPlatform' => 'required|string',
            'editingUrl' => 'required|url',
            'editingIcon' => 'required|string'
        ]);
        
        $link = SocialLink::find($this->editingId);
        if ($link) {
            $link->update([
                'platform' => $this->editingPlatform,
                'url' => $this->editingUrl,
                'icon' => $this->editingIcon
            ]);
            
            $this->cancelEdit();
            $this->loadLinks();
            session()->flash('success', __('footer.link_updated'));
        }
    }
    
    public function toggleActive($id)
    {
        $link = SocialLink::find($id);
        if ($link) {
            $link->active = !$link->active;
            $link->save();
            $this->loadLinks();
        }
    }
    
    public function delete($id)
    {
        SocialLink::destroy($id);
        $this->loadLinks();
        session()->flash('success', __('footer.link_deleted'));
    }
    
    public function moveUp($id)
    {
        $link = SocialLink::find($id);
        if ($link && $link->order > 0) {
            $previousLink = SocialLink::where('order', $link->order - 1)->first();
            if ($previousLink) {
                $previousLink->order = $link->order;
                $previousLink->save();
            }
            $link->order = $link->order - 1;
            $link->save();
            $this->loadLinks();
        }
    }
    
    public function moveDown($id)
    {
        $link = SocialLink::find($id);
        $maxOrder = SocialLink::max('order');
        if ($link && $link->order < $maxOrder) {
            $nextLink = SocialLink::where('order', $link->order + 1)->first();
            if ($nextLink) {
                $nextLink->order = $link->order;
                $nextLink->save();
            }
            $link->order = $link->order + 1;
            $link->save();
            $this->loadLinks();
        }
    }
    
    public function render()
    {
        return view('livewire.hrace009.admin.social-links-manager');
    }
}
