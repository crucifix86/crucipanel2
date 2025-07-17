<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;

class CheckThemeFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:check-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check theme CSS files to see if they have different content';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $themes = Theme::all();
        $themesDir = public_path('css/themes/');
        
        $this->info('Checking theme files in: ' . $themesDir);
        $this->info('');
        
        $fileHashes = [];
        
        foreach ($themes as $theme) {
            $fileName = 'theme-' . $theme->name . '.css';
            $filePath = $themesDir . $fileName;
            
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                $size = filesize($filePath);
                $hash = md5($content);
                $firstLine = strtok($content, "\n");
                
                $this->info("Theme: {$theme->display_name} ({$theme->name})");
                $this->info("  File: {$fileName}");
                $this->info("  Size: " . number_format($size) . " bytes");
                $this->info("  Hash: {$hash}");
                $this->info("  First line: " . substr($firstLine, 0, 60) . "...");
                
                // Track duplicate content
                if (isset($fileHashes[$hash])) {
                    $this->error("  ⚠️  DUPLICATE CONTENT! Same as: " . $fileHashes[$hash]);
                } else {
                    $fileHashes[$hash] = $theme->name;
                }
            } else {
                $this->warn("Theme: {$theme->display_name} ({$theme->name})");
                $this->warn("  File: {$fileName} - NOT FOUND");
            }
            
            $this->info('');
        }
        
        return 0;
    }
}