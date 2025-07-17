<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;
use Illuminate\Support\Facades\File;

class RestoreThemesFromDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:restore-from-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore theme CSS files from database content';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $themes = Theme::all();
        
        $this->info('Restoring theme CSS files from database content...');
        $this->info('');
        
        foreach ($themes as $theme) {
            $fileName = 'theme-' . $theme->name . '.css';
            $filePath = public_path('css/themes/' . $fileName);
            
            if (!empty($theme->css_content)) {
                // Remove any test CSS we added
                $content = $theme->css_content;
                $content = preg_replace('/\/\* TEST SAVE.*?\*\/\n.*?\n.*?\n\n/s', '', $content);
                
                // Save to file
                File::put($filePath, $content);
                
                $this->info("Restored: {$theme->display_name} ({$fileName})");
                $this->info("  Size: " . filesize($filePath) . " bytes");
            } else {
                $this->warn("Skipped: {$theme->display_name} - No database content");
            }
        }
        
        $this->info('');
        $this->info('Theme files restored from database!');
        
        return 0;
    }
}