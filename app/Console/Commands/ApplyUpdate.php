<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ApplyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply pending panel update';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingFile = storage_path('app/updates/pending.json');
        
        if (!File::exists($pendingFile)) {
            $this->error('No pending update found.');
            return 1;
        }
        
        $updateInfo = json_decode(File::get($pendingFile), true);
        
        if (!File::exists($updateInfo['zip_file'])) {
            $this->error('Update file not found.');
            return 1;
        }
        
        $this->info('Applying update to version ' . $updateInfo['version'] . '...');
        
        // Put app in maintenance mode
        $this->info('Putting application in maintenance mode...');
        Artisan::call('down', ['--retry' => 60]);
        
        try {
            // Extract update
            $this->info('Extracting update files...');
            $zip = new ZipArchive();
            
            if ($zip->open($updateInfo['zip_file']) === TRUE) {
                $extractPath = storage_path('app/temp/extract_' . $updateInfo['version']);
                $zip->extractTo($extractPath);
                $zip->close();
                
                // Find the actual project directory
                $dirs = File::directories($extractPath);
                $sourceDir = $dirs[0] ?? $extractPath;
                
                // Copy files
                $this->info('Copying files...');
                $this->copyFiles($sourceDir, base_path());
                
                // Update version
                $this->updateVersion($updateInfo['version']);
                
                // Clean up
                File::deleteDirectory($extractPath);
                File::delete($updateInfo['zip_file']);
                File::delete($pendingFile);
                
                // Clear caches
                $this->info('Clearing caches...');
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                Artisan::call('optimize:clear');
                
                // Run migrations
                $this->info('Running migrations...');
                Artisan::call('migrate', ['--force' => true]);
                
                // Rebuild caches
                $this->info('Rebuilding caches...');
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                
                // Bring app back online
                $this->info('Bringing application back online...');
                Artisan::call('up');
                
                $this->info('Update completed successfully!');
                return 0;
            }
            
            $this->error('Failed to extract update file.');
            Artisan::call('up');
            return 1;
            
        } catch (\Exception $e) {
            $this->error('Update failed: ' . $e->getMessage());
            Artisan::call('up');
            return 1;
        }
    }
    
    private function copyFiles($source, $destination)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        $skipPaths = ['.env', 'storage/', 'vendor/', 'node_modules/', '.git', 'bootstrap/cache/'];
        
        foreach ($iterator as $item) {
            $destPath = $destination . '/' . $iterator->getSubPathName();
            
            $skip = false;
            foreach ($skipPaths as $skipPath) {
                if (strpos($iterator->getSubPathName(), $skipPath) === 0) {
                    $skip = true;
                    break;
                }
            }
            
            if ($skip) continue;
            
            if ($item->isDir()) {
                if (!File::exists($destPath)) {
                    File::makeDirectory($destPath, 0755, true);
                }
            } else {
                File::copy($item, $destPath);
            }
        }
    }
    
    private function updateVersion($version)
    {
        $configPath = config_path('pw-config.php');
        $config = File::get($configPath);
        
        $config = preg_replace(
            "/'version'\s*=>\s*'[^']*'/",
            "'version' => '" . $version . "'",
            $config
        );
        
        File::put($configPath, $config);
    }
}