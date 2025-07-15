<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\LocalSettings;
use Illuminate\Support\Facades\Config;

class RestoreLocalSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:restore {--force : Force restore without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore all settings from local JSON backup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = LocalSettings::all();
        
        if (empty($settings)) {
            $this->error('No local settings found to restore.');
            return 1;
        }
        
        $this->info('Found ' . count($settings) . ' settings to restore.');
        
        if (!$this->option('force') && !$this->confirm('Do you want to restore these settings?')) {
            $this->info('Restoration cancelled.');
            return 0;
        }
        
        // Restore each setting
        foreach ($settings as $key => $value) {
            // Write to config files
            Config::write($key, $value);
            $this->line("Restored: {$key}");
        }
        
        // Clear and rebuild cache
        $this->call('config:clear');
        $this->call('config:cache');
        
        $this->info('Successfully restored ' . count($settings) . ' settings from local backup.');
        
        return 0;
    }
}