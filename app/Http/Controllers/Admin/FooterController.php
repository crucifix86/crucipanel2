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
            'alignment' => 'required|in:left,center,right',
            'footer_image' => 'nullable|image|mimes:svg,png,jpg,jpeg,gif|max:2048',
            'footer_image_link' => 'nullable|url|max:255',
            'footer_image_alt' => 'nullable|string|max:255',
            'footer_image_path' => 'nullable|string|max:255'
        ]);
        
        $footerSettings = FooterSetting::firstOrNew(['id' => 1]);
        
        // Handle footer image upload
        if ($request->hasFile('footer_image')) {
            $imagePath = $request->file('footer_image')->store('footer', 'public');
            $footerSettings->footer_image = 'storage/' . $imagePath;
        } elseif ($request->filled('footer_image_path')) {
            $footerSettings->footer_image = $request->footer_image_path;
        }
        
        // Update other fields
        $footerSettings->content = $validated['content'] ?? null;
        $footerSettings->copyright = $validated['copyright'] ?? null;
        $footerSettings->alignment = $validated['alignment'];
        $footerSettings->footer_image_link = $validated['footer_image_link'] ?? null;
        $footerSettings->footer_image_alt = $validated['footer_image_alt'] ?? null;
        
        $footerSettings->save();
        
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
