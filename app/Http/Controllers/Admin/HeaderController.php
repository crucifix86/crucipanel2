<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function index(): View
    {
        try {
            $headerSettings = HeaderSetting::first();
        } catch (\Exception $e) {
            $headerSettings = null;
        }
        
        return view('admin.header.index', compact('headerSettings'));
    }
    
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'alignment' => 'required|in:left,center,right',
            'header_logo' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
            'badge_logo' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
            'header_logo_path' => 'nullable|string|max:255',
            'badge_logo_path' => 'nullable|string|max:255'
        ]);
        
        $headerSettings = HeaderSetting::firstOrNew(['id' => 1]);
        
        // Update content and alignment if provided
        if ($request->has('content')) {
            $headerSettings->content = $validated['content'] ?? null;
            $headerSettings->alignment = $validated['alignment'];
        }
        
        // Handle header logo upload
        if ($request->hasFile('header_logo')) {
            $headerPath = $request->file('header_logo')->store('logos', 'public');
            $headerSettings->header_logo = 'storage/' . $headerPath;
        } elseif ($request->filled('header_logo_path')) {
            $headerSettings->header_logo = $request->header_logo_path;
        }
        
        // Handle badge logo upload
        if ($request->hasFile('badge_logo')) {
            $badgePath = $request->file('badge_logo')->store('logos', 'public');
            $headerSettings->badge_logo = 'storage/' . $badgePath;
        } elseif ($request->filled('badge_logo_path')) {
            $headerSettings->badge_logo = $request->badge_logo_path;
        }
        
        $headerSettings->save();
        
        return redirect()->back()->with('success', __('header.settings_updated'));
    }
}