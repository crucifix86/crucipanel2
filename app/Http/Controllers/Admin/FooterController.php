<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FooterController extends Controller
{
    public function index(): View
    {
        try {
            $footerSettings = FooterSetting::first();
            $socialLinks = SocialLink::orderBy('order')->get();
        } catch (\Exception $e) {
            $footerSettings = null;
            $socialLinks = collect();
        }
        
        return view('admin.footer.index', compact('footerSettings', 'socialLinks'));
    }
    
    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'copyright' => 'nullable|string|max:255',
            'alignment' => 'required|in:left,center,right'
        ]);
        
        FooterSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );
        
        return redirect()->back()->with('success', __('footer.content_updated'));
    }
    
    public function storeSocialLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255'
        ]);
        
        // Auto-set icon based on platform
        $icons = [
            'facebook' => 'fa-brands fa-facebook',
            'twitter' => 'fa-brands fa-twitter',
            'instagram' => 'fa-brands fa-instagram',
            'youtube' => 'fa-brands fa-youtube',
            'linkedin' => 'fa-brands fa-linkedin',
            'discord' => 'fa-brands fa-discord',
            'twitch' => 'fa-brands fa-twitch',
            'github' => 'fa-brands fa-github',
            'tiktok' => 'fa-brands fa-tiktok',
            'reddit' => 'fa-brands fa-reddit'
        ];
        
        $icon = $icons[strtolower($validated['platform'])] ?? 'fa-solid fa-link';
        
        $maxOrder = SocialLink::max('order') ?? -1;
        
        SocialLink::create([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'icon' => $icon,
            'order' => $maxOrder + 1,
            'active' => true
        ]);
        
        return redirect()->back()->with('success', __('footer.social_link_added'));
    }
}
