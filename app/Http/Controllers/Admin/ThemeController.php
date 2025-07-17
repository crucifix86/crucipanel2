<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        $activeTheme = Theme::getActive();
        
        \Log::info('ThemeController index - themes count: ' . $themes->count());
        \Log::info('ThemeController index - themes: ' . $themes->toJson());
        
        return view('admin.themes.index', compact('themes', 'activeTheme'));
    }

    public function toggleVisibility(Theme $theme)
    {
        $theme->is_visible = !$theme->is_visible;
        $theme->save();
        
        $message = $theme->is_visible ? 'Theme is now visible to users!' : 'Theme is now hidden from users!';
        return redirect()->route('admin.themes.index')->with('success', $message);
    }

    public function clone(Theme $theme, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:themes,name|regex:/^[a-z0-9-]+$/',
            'display_name' => 'required|string'
        ]);
        
        $newTheme = $theme->clone($validated['name'], $validated['display_name']);
        
        // Create CSS file for the new theme
        $sourceFileName = 'theme-' . $theme->name . '.css';
        $sourcePath = public_path('css/themes/' . $sourceFileName);
        
        // If source theme file doesn't exist, check if theme has database content
        if (!File::exists($sourcePath) && !empty($theme->css_content)) {
            // Create the source file from database content first
            File::put($sourcePath, $theme->css_content);
        } elseif (!File::exists($sourcePath)) {
            // Only use unified CSS as last resort
            $sourcePath = public_path('css/mystical-purple-unified.css');
        }
        
        // Create the new theme CSS file
        $newFileName = 'theme-' . $newTheme->name . '.css';
        $newPath = public_path('css/themes/' . $newFileName);
        
        if (File::exists($sourcePath)) {
            File::copy($sourcePath, $newPath);
        }
        
        return redirect()->route('admin.themes.index')->with('success', 'Theme cloned successfully!');
    }

    public function edit(Theme $theme)
    {
        if (!$theme->is_editable) {
            return redirect()->route('admin.themes.index')->with('error', 'This theme cannot be edited.');
        }
        
        // Load CSS content from theme-specific file if it exists
        $themeFileName = 'theme-' . $theme->name . '.css';
        $cssFilePath = public_path('css/themes/' . $themeFileName);
        
        // Load from file if it exists
        if (File::exists($cssFilePath)) {
            $theme->css_content = File::get($cssFilePath);
        } else {
            // Only if file doesn't exist, check database first, then use default
            if (!empty($theme->css_content)) {
                // Theme has content in database, use that
                // Don't overwrite with default!
            } else {
                // No file and no database content, load default
                $defaultPath = public_path('css/mystical-purple-unified.css');
                if (File::exists($defaultPath)) {
                    $theme->css_content = File::get($defaultPath);
                }
            }
        }
        
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Theme $theme, Request $request)
    {
        if (!$theme->is_editable) {
            return redirect()->route('admin.themes.index')->with('error', 'This theme cannot be edited.');
        }
        
        $validated = $request->validate([
            'css_content' => 'nullable|string',
            'js_content' => 'nullable|string',
            'layout_content' => 'nullable|string',
            'tab' => 'required|in:css,js,layout'
        ]);
        
        // Update only the edited tab content
        switch ($validated['tab']) {
            case 'css':
                // Save CSS to theme-specific file
                $themeFileName = 'theme-' . $theme->name . '.css';
                $cssFilePath = public_path('css/themes/' . $themeFileName);
                
                // Log what we're doing
                \Log::info('Saving theme CSS', [
                    'theme' => $theme->name,
                    'file' => $cssFilePath,
                    'content_length' => strlen($validated['css_content']),
                    'file_exists_before' => file_exists($cssFilePath)
                ]);
                
                File::put($cssFilePath, $validated['css_content']);
                
                // Verify it saved
                $saved = file_exists($cssFilePath) && file_get_contents($cssFilePath) === $validated['css_content'];
                \Log::info('Theme CSS save result', [
                    'saved' => $saved,
                    'file_size' => file_exists($cssFilePath) ? filesize($cssFilePath) : 0
                ]);
                
                // Update database to keep it in sync
                $theme->css_content = $validated['css_content'];
                break;
            case 'js':
                $theme->js_content = $validated['js_content'];
                break;
            case 'layout':
                $theme->layout_content = $validated['layout_content'];
                break;
        }
        
        $theme->save();
        
        return redirect()->route('admin.themes.edit', $theme)
            ->with('success', 'Theme updated successfully!')
            ->with('active_tab', $validated['tab']);
    }

    public function revertToSafety()
    {
        $defaultTheme = Theme::where('is_default', true)->first();
        
        if ($defaultTheme) {
            // Deactivate all themes
            Theme::where('is_active', true)->update(['is_active' => false]);
            
            // Activate default theme
            $defaultTheme->is_active = true;
            $defaultTheme->save();
        }
        
        return redirect()->route('admin.themes.index')->with('success', 'Reverted to safety theme successfully!');
    }

    public function toggleAuthTheme(Theme $theme)
    {
        // First, remove auth theme status from all themes
        Theme::where('is_auth_theme', true)->update(['is_auth_theme' => false]);
        
        // Toggle the auth theme status for this theme
        $theme->is_auth_theme = true;
        $theme->save();
        
        return redirect()->route('admin.themes.index')->with('success', 'Auth theme set to: ' . $theme->display_name);
    }

    public function setAsDefault(Theme $theme)
    {
        // Deactivate all themes
        Theme::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected theme
        $theme->is_active = true;
        $theme->save();
        
        return redirect()->route('admin.themes.index')->with('success', 'Site default theme set to: ' . $theme->display_name);
    }

    public function destroy(Theme $theme)
    {
        // Don't allow deletion of default or auth themes
        if ($theme->is_default) {
            return redirect()->route('admin.themes.index')->with('error', 'Cannot delete the default theme.');
        }
        
        if ($theme->is_auth_theme) {
            return redirect()->route('admin.themes.index')->with('error', 'Cannot delete the auth theme. Please set another theme as auth theme first.');
        }
        
        if ($theme->is_active) {
            return redirect()->route('admin.themes.index')->with('error', 'Cannot delete an active theme. Please activate another theme first.');
        }
        
        // Delete the theme CSS file
        $themeFileName = 'theme-' . $theme->name . '.css';
        $cssFilePath = public_path('css/themes/' . $themeFileName);
        if (File::exists($cssFilePath)) {
            File::delete($cssFilePath);
        }
        
        // Delete the theme record
        $theme->delete();
        
        return redirect()->route('admin.themes.index')->with('success', 'Theme deleted successfully!');
    }

    public function resetAllUsersToDefault()
    {
        // Get the active theme (site default)
        $activeTheme = Theme::where('is_active', true)->first();
        
        if (!$activeTheme) {
            return redirect()->route('admin.themes.index')->with('error', 'No active theme found. Please set a default theme first.');
        }
        
        // Reset all users to null theme_id (which will make them use the site default)
        \App\Models\User::query()->update(['theme_id' => null]);
        
        // Clear all theme sessions
        \DB::table('sessions')->update(['payload' => \DB::raw("REPLACE(payload, 'active_theme_id', 'old_active_theme_id')")]);
        
        return redirect()->route('admin.themes.index')->with('success', 'All users have been reset to use the default theme.');
    }
}