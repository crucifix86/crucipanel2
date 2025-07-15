<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class RestoreSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore all settings from LocalSettings after updates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Restoring settings from panel-settings.json...');
        
        $settingsPath = storage_path('app/panel-settings.json');
        
        if (!file_exists($settingsPath)) {
            $this->warn('No settings file found at: ' . $settingsPath);
            return 0;
        }
        
        $settings = json_decode(file_get_contents($settingsPath), true);
        
        if (empty($settings)) {
            $this->warn('No settings found in file.');
            return 0;
        }
        
        $count = 0;
        
        // Restore pw-config settings
        if (isset($settings['pw-config'])) {
            foreach ($settings['pw-config'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue) {
                        Config::write("pw-config.{$key}.{$subKey}", $subValue);
                        $this->line("Restored: pw-config.{$key}.{$subKey}");
                        $count++;
                    }
                } else {
                    Config::write("pw-config.{$key}", $value);
                    $this->line("Restored: pw-config.{$key}");
                    $count++;
                }
            }
        }
        
        // Restore app settings
        if (isset($settings['app'])) {
            foreach ($settings['app'] as $key => $value) {
                Config::write("app.{$key}", $value);
                $this->line("Restored: app.{$key}");
                $count++;
            }
        }
        
        // Clear and rebuild config cache
        $this->call('config:clear');
        $this->call('config:cache');
        
        $this->info("Successfully restored {$count} settings!");
        
        return 0;
    }
}