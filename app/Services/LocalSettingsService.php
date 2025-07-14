<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LocalSettingsService
{
    /**
     * Path to the local settings file
     */
    protected $settingsPath;
    
    public function __construct()
    {
        $this->settingsPath = storage_path('app/local-settings.json');
    }
    
    /**
     * Get a setting value
     */
    public function get($key, $default = null)
    {
        $settings = $this->loadSettings();
        return data_get($settings, $key, $default);
    }
    
    /**
     * Set a setting value
     */
    public function set($key, $value)
    {
        $settings = $this->loadSettings();
        data_set($settings, $key, $value);
        $this->saveSettings($settings);
    }
    
    /**
     * Set multiple settings at once
     */
    public function setMany(array $values)
    {
        $settings = $this->loadSettings();
        foreach ($values as $key => $value) {
            data_set($settings, $key, $value);
        }
        $this->saveSettings($settings);
    }
    
    /**
     * Get all settings
     */
    public function all()
    {
        return $this->loadSettings();
    }
    
    /**
     * Load settings from file
     */
    protected function loadSettings()
    {
        if (!File::exists($this->settingsPath)) {
            return [];
        }
        
        $content = File::get($this->settingsPath);
        return json_decode($content, true) ?: [];
    }
    
    /**
     * Save settings to file
     */
    protected function saveSettings(array $settings)
    {
        $directory = dirname($this->settingsPath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        File::put($this->settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
    }
    
    /**
     * Export settings to array
     */
    public function export()
    {
        return $this->loadSettings();
    }
    
    /**
     * Import settings from array
     */
    public function import(array $settings)
    {
        $this->saveSettings($settings);
    }
    
    /**
     * Clear all settings
     */
    public function clear()
    {
        if (File::exists($this->settingsPath)) {
            File::delete($this->settingsPath);
        }
    }
}