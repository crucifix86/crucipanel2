<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Facades\LocalSettings;
use Illuminate\Http\Request;

class LocalSettingsController extends Controller
{
    /**
     * Show the local settings management page
     */
    public function index()
    {
        $settings = LocalSettings::all();
        return view('admin.system.local-settings', compact('settings'));
    }
    
    /**
     * Export settings as JSON
     */
    public function export()
    {
        $settings = LocalSettings::export();
        
        return response()->json($settings)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="panel-settings-' . date('Y-m-d') . '.json"');
    }
    
    /**
     * Import settings from JSON
     */
    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json|max:2048'
        ]);
        
        try {
            $content = file_get_contents($request->file('settings_file')->getRealPath());
            $settings = json_decode($content, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON file');
            }
            
            // Import the settings
            LocalSettings::import($settings);
            
            // Also update current config
            foreach ($settings as $key => $value) {
                config([$key => $value]);
            }
            
            return redirect()->route('admin.local-settings.index')
                ->with('success', 'Settings imported successfully! Total: ' . count($settings) . ' settings');
        } catch (\Exception $e) {
            return redirect()->route('admin.local-settings.index')
                ->with('error', 'Failed to import settings: ' . $e->getMessage());
        }
    }
    
    /**
     * Clear all local settings
     */
    public function clear(Request $request)
    {
        if ($request->get('confirm') === 'yes') {
            LocalSettings::clear();
            
            return redirect()->route('admin.local-settings.index')
                ->with('success', 'All local settings have been cleared.');
        }
        
        return redirect()->route('admin.local-settings.index')
            ->with('error', 'Please confirm the action.');
    }
}