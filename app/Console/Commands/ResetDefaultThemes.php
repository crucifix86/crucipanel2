<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;
use Illuminate\Support\Facades\File;

class ResetDefaultThemes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:reset-defaults';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset default theme and first clone to original purple theme';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the original purple CSS
        $originalCss = File::get(public_path('css/mystical-purple-unified.css'));
        
        // Reset default theme
        $defaultTheme = Theme::where('is_default', true)->first();
        if ($defaultTheme) {
            $fileName = 'theme-' . $defaultTheme->name . '.css';
            $filePath = public_path('css/themes/' . $fileName);
            
            File::put($filePath, $originalCss);
            $defaultTheme->css_content = $originalCss;
            $defaultTheme->save();
            
            $this->info("Reset: {$defaultTheme->display_name} ({$fileName})");
        }
        
        // Reset the first non-default theme (usually the first clone)
        $firstClone = Theme::where('is_default', false)
                          ->orderBy('id', 'asc')
                          ->first();
                          
        if ($firstClone) {
            $fileName = 'theme-' . $firstClone->name . '.css';
            $filePath = public_path('css/themes/' . $fileName);
            
            File::put($filePath, $originalCss);
            $firstClone->css_content = $originalCss;
            $firstClone->save();
            
            $this->info("Reset: {$firstClone->display_name} ({$fileName})");
        }
        
        $this->info('');
        $this->info('Default themes reset to original purple theme!');
        $this->info('You can now delete and recreate your custom themes.');
        
        return 0;
    }
}