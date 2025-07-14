<?php

use App\Facades\LocalSettings;

if (!function_exists('get_setting')) {
    /**
     * Get a setting value from local settings first, then fallback to config
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        // First check local settings
        $localValue = LocalSettings::get($key);
        if ($localValue !== null) {
            return $localValue;
        }
        
        // Fallback to config
        return config($key, $default);
    }
}

if (!function_exists('set_setting')) {
    /**
     * Set a setting value in both local settings and config
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    function set_setting($key, $value)
    {
        // Save to local settings
        LocalSettings::set($key, $value);
        
        // Also update config for current request
        config([$key => $value]);
    }
}