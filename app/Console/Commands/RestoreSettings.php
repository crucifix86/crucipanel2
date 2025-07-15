<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\LocalSettings;
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
        $this->info('Restoring settings from LocalSettings...');
        
        // Get all settings from LocalSettings
        $settings = LocalSettings::all();
        
        if (empty($settings)) {
            $this->warn('No settings found in LocalSettings.');
            return 0;
        }
        
        $count = 0;
        foreach ($settings as $key => $value) {
            // Write each setting back to config
            Config::write($key, $value);
            $count++;
            $this->line("Restored: {$key}");
        }
        
        // Clear and rebuild config cache
        $this->call('config:clear');
        $this->call('config:cache');
        
        $this->info("Successfully restored {$count} settings!");
        
        return 0;
    }
}