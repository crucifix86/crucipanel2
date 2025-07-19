<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SetupFactionIcons extends Command
{
    protected $signature = 'faction-icons:setup';
    protected $description = 'Setup faction icons directories and permissions';

    public function handle()
    {
        $this->info('Setting up faction icons directories...');
        
        // Create directories
        Storage::disk('public')->makeDirectory('faction-icons', 0755, true);
        
        // Create symbolic link if it doesn't exist
        $publicPath = public_path('storage');
        $storagePath = storage_path('app/public');
        
        if (!file_exists($publicPath)) {
            $this->call('storage:link');
        }
        
        $this->info('Faction icons directories created successfully!');
        $this->info('Storage path: ' . storage_path('app/public/faction-icons'));
        $this->info('Public path: ' . public_path('storage/faction-icons'));
        
        return 0;
    }
}