<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;
use Illuminate\Support\Facades\File;

class GenerateThemeFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:generate-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CSS files for themes that don\'t have them';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $themes = Theme::all();
        $defaultCssPath = public_path('css/mystical-purple-unified.css');
        
        if (!File::exists($defaultCssPath)) {
            $this->error('Default CSS file not found at: ' . $defaultCssPath);
            return 1;
        }
        
        $this->info('Generating theme CSS files...');
        
        foreach ($themes as $theme) {
            $themeFileName = 'theme-' . $theme->name . '.css';
            $themePath = public_path('css/themes/' . $themeFileName);
            
            if (!File::exists($themePath)) {
                // Copy the default CSS to create the theme file
                File::copy($defaultCssPath, $themePath);
                $this->info('Created CSS file for theme: ' . $theme->display_name . ' at ' . $themeFileName);
            } else {
                $this->info('CSS file already exists for theme: ' . $theme->display_name);
            }
        }
        
        $this->info('Theme files generation completed!');
        return 0;
    }
}