<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use App\Facades\LocalSettings;

trait SavesConfigSettings
{
    /**
     * Write a config value and save it to local settings
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function writeConfig($key, $value)
    {
        // Write to config files
        Config::write($key, $value);
        
        // Also save to local settings for persistence
        LocalSettings::set($key, $value);
    }
    
    /**
     * Write multiple config values and save them to local settings
     * 
     * @param array $settings
     * @return void
     */
    protected function writeConfigMany(array $settings)
    {
        foreach ($settings as $key => $value) {
            Config::write($key, $value);
        }
        
        // Save all to local settings at once
        LocalSettings::setMany($settings);
    }
}