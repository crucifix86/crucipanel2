<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
                
                // Run seeders for new features
                $this->info('Checking for new seeders...');
                $this->runNewSeeders();
                
                // Publish vendor assets
                $this->info('Publishing vendor assets...');
                
                // Ensure vendor directory exists
                $vendorPath = public_path('vendor');
                if (!File::exists($vendorPath)) {
                    File::makeDirectory($vendorPath, 0755, true);
                }
                
                // Publish Livewire assets
                $this->call('livewire:publish', ['--assets' => true]);
                
                // Publish other vendor assets
                Artisan::call('vendor:publish', ['--tag' => 'laravel-popper', '--force' => true]);
                
                // Rebuild assets if npm is available
                $this->info('Checking for asset rebuild...');
                if (File::exists(base_path('package.json'))) {
                    $npmCheck = shell_exec('which npm 2>/dev/null');
                    if ($npmCheck) {
                        $this->info('Rebuilding assets...');
                        $this->info('This may take a few minutes...');
                        shell_exec('cd ' . base_path() . ' && npm run production 2>&1');
                    } else {
                        $this->warn('npm not found. Skipping asset rebuild.');
                        $this->warn('Run "npm run production" manually if needed.');
                    }
                }
                
                // Settings restoration removed - was causing errors
                
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
        // First, backup pw-config.php
        $pwConfigPath = $destination . '/config/pw-config.php';
        $pwConfigBackup = null;
        if (File::exists($pwConfigPath)) {
            $pwConfigBackup = File::get($pwConfigPath);
        }
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        $skipPaths = ['.env', 'storage/', 'vendor/', 'node_modules/', '.git', 'bootstrap/cache/'];
        
        foreach ($iterator as $item) {
            $destPath = $destination . '/' . $iterator->getSubPathName();
            
            // Special handling for pw-config.php
            if ($iterator->getSubPathName() === 'config/pw-config.php') {
                continue; // Skip copying this file
            }
            
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
                // Copy the file
                File::copy($item, $destPath);
            }
        }
        
        // Restore pw-config.php if we had a backup
        if ($pwConfigBackup !== null) {
            File::put($pwConfigPath, $pwConfigBackup);
            chmod($pwConfigPath, 0664); // Ensure it's writable
        }
        
        // After copying, ensure critical directories have correct permissions
        $this->fixPermissions($destination);
    }
    
    private function fixPermissions($basePath)
    {
        $this->info('Setting correct file permissions...');
        
        // Critical directories that must be writable
        $writableDirectories = [
            'storage',
            'bootstrap/cache',
        ];
        
        // Set directory permissions
        foreach ($writableDirectories as $dir) {
            $path = $basePath . '/' . $dir;
            if (File::exists($path)) {
                shell_exec("chmod -R 775 " . escapeshellarg($path) . " 2>&1");
            }
        }
        
        // Ensure config directory is writable
        $configPath = $basePath . '/config';
        if (File::exists($configPath)) {
            shell_exec("chmod 755 " . escapeshellarg($configPath) . " 2>&1");
            shell_exec("chmod 664 " . escapeshellarg($configPath) . "/*.php 2>&1");
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
    
    private function runNewSeeders()
    {
        $this->info('Checking for new seeders to run...');
        
        // List of seeders to run for specific features
        $seeders = [
            'Database\\Seeders\\ThemeSeeder' => 'themes', // Seeder => table
        ];
        
        foreach ($seeders as $seederClass => $tableName) {
            try {
                // Check if the feature table exists
                if (!Schema::hasTable($tableName)) {
                    $this->warn("Table {$tableName} does not exist, skipping seeder {$seederClass}");
                    continue;
                }
                
                $count = DB::table($tableName)->count();
                
                // Only run seeder if table is empty
                if ($count == 0) {
                    $this->info("Running seeder: {$seederClass}");
                    
                    $result = Artisan::call('db:seed', [
                        '--class' => $seederClass,
                        '--force' => true
                    ]);
                    
                    if ($result === 0) {
                        $this->info("✓ Seeder {$seederClass} completed successfully");
                    } else {
                        $this->error("✗ Seeder {$seederClass} failed with exit code: {$result}");
                    }
                } else {
                    $this->info("Skipping seeder {$seederClass} - table {$tableName} already has {$count} records");
                }
            } catch (\Exception $e) {
                $this->error("Failed to run seeder {$seederClass}: " . $e->getMessage());
                $this->error("Stack trace: " . $e->getTraceAsString());
                // Continue with other seeders even if one fails
            }
        }
        
        $this->info('Seeder check completed.');
    }
}