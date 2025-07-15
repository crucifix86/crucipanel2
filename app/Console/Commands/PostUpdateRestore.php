<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostUpdateRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:post-restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run after panel updates to restore settings and perform other post-update tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running post-update restoration...');
        
        // Restore local settings
        $this->call('settings:restore', ['--force' => true]);
        
        // Run migrations
        $this->call('migrate', ['--force' => true]);
        
        // Clear all caches
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        
        // Rebuild caches
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        
        $this->info('Post-update restoration completed successfully!');
        
        return 0;
    }
}