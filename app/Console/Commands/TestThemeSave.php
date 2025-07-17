<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;

class TestThemeSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:test-save {theme} {--color=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test saving a theme with different CSS to verify save mechanism works';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $themeName = $this->argument('theme');
        $theme = Theme::where('name', $themeName)->first();
        
        if (!$theme) {
            $this->error("Theme '{$themeName}' not found!");
            return 1;
        }
        
        $color = $this->option('color') ?: '#ff0000';
        
        // Load current CSS
        $fileName = 'theme-' . $theme->name . '.css';
        $filePath = public_path('css/themes/' . $fileName);
        
        if (file_exists($filePath)) {
            $currentCss = file_get_contents($filePath);
        } else {
            $currentCss = file_get_contents(public_path('css/mystical-purple-unified.css'));
        }
        
        // Add a test style at the beginning
        $testCss = "/* TEST SAVE - " . now()->format('Y-m-d H:i:s') . " */\n";
        $testCss .= "body { background: {$color} !important; }\n";
        $testCss .= "body::after { content: 'TEST THEME SAVE WORKED'; position: fixed; top: 50%; left: 50%; font-size: 48px; color: white; }\n\n";
        $testCss .= $currentCss;
        
        // Save to file
        file_put_contents($filePath, $testCss);
        
        // Also update database
        $theme->css_content = $testCss;
        $theme->save();
        
        $this->info("Test CSS saved to: {$filePath}");
        $this->info("File size: " . filesize($filePath) . " bytes");
        $this->info("If save worked, the site should have a {$color} background");
        
        return 0;
    }
}