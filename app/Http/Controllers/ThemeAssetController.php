<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeAssetController extends Controller
{
    public function css()
    {
        $theme = Theme::getActive();
        
        if (!$theme) {
            // Return default theme CSS  
            $defaultTheme = Theme::where('is_default', true)->first();
            if ($defaultTheme) {
                $theme = $defaultTheme;
            } else {
                // If no theme at all, load the unified CSS directly
                $cssPath = public_path('css/mystical-purple-unified.css');
                if (file_exists($cssPath)) {
                    $css = file_get_contents($cssPath);
                } else {
                    $css = "/* ERROR: No CSS file found */";
                }
                return response($css)
                    ->header('Content-Type', 'text/css')
                    ->header('Cache-Control', 'no-cache, must-revalidate');
            }
        }
        
        // First, try to load from file if it exists
        $themeFile = public_path('css/themes/theme-' . $theme->name . '.css');
        
        if (file_exists($themeFile)) {
            // Load from file
            $css = file_get_contents($themeFile);
        } else {
            // Fall back to database content
            $css = $theme->css_content;
            
            // If database is empty, use unified CSS
            if (empty($css)) {
                $unifiedPath = public_path('css/mystical-purple-unified.css');
                if (file_exists($unifiedPath)) {
                    $css = file_get_contents($unifiedPath);
                } else {
                    $css = "/* ERROR: No unified CSS found */";
                }
            }
        }
        
        return response($css)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
    
    public function js()
    {
        $theme = Theme::getActive();
        
        if (!$theme) {
            // Return default JS if no theme found
            $defaultTheme = Theme::where('is_default', true)->first();
            if ($defaultTheme) {
                return response($defaultTheme->js_content)
                    ->header('Content-Type', 'application/javascript')
                    ->header('Cache-Control', 'no-cache, must-revalidate');
            }
            abort(404);
        }
        
        return response($theme->js_content)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
}