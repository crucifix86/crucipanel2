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
        $footerSettings = FooterSetting::first();
        $socialLinks = SocialLink::orderBy('order')->get();
        
        return view('admin.footer.index', compact('footerSettings', 'socialLinks'));
    }
    
    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'copyright' => 'nullable|string|max:255'
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
            'url' => 'required|url|max:255',
            'icon' => 'required|string|max:255'
        ]);
        
        $maxOrder = SocialLink::max('order') ?? -1;
        
        SocialLink::create([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'icon' => $validated['icon'],
            'order' => $maxOrder + 1,
            'active' => true
        ]);
        
        return redirect()->back()->with('success', __('footer.social_link_added'));
    }
}
