<?php

/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class UpdateController extends Controller
{
    /**
     * Display the update page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currentVersion = config('pw-config.version', '1.0');
        $latestRelease = $this->checkForUpdates();
        
        return view('admin.system.update', [
            'currentVersion' => $currentVersion,
            'latestRelease' => $latestRelease,
            'updateAvailable' => $this->isUpdateAvailable($currentVersion, $latestRelease)
        ]);
    }
    
    /**
     * Check for updates from GitHub
     *
     * @return array|null
     */
    public function checkForUpdates()
    {
        try {
            $response = Http::get('https://api.github.com/repos/crucifix86/crucipanel2/releases/latest');
            
            if ($response->successful()) {
                $release = $response->json();
                return [
                    'version' => ltrim($release['tag_name'], 'v'),
                    'notes' => $release['body'],
                    'download_url' => $release['zipball_url'],
                    'published_at' => $release['published_at'],
                    'html_url' => $release['html_url']
                ];
            } elseif ($response->status() === 404) {
                // No releases found - this is not an error
                return ['no_releases' => true];
            }
        } catch (\Exception $e) {
            \Log::error('Failed to check for updates: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Check if update is available
     *
     * @param string $currentVersion
     * @param array|null $latestRelease
     * @return bool
     */
    private function isUpdateAvailable($currentVersion, $latestRelease)
    {
        if (!$latestRelease) {
            return false;
        }
        
        return version_compare($latestRelease['version'], $currentVersion, '>');
    }
    
    /**
     * Create backup before update
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createBackup()
    {
        try {
            // Clean any output buffer to ensure clean JSON response
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $backupName = 'backup_' . date('Y-m-d_H-i-s') . '.zip';
            $backupPath = storage_path('app/backups/' . $backupName);
            
            // Create backups directory if it doesn't exist
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }
            
            $zip = new ZipArchive();
            
            if ($zip->open($backupPath, ZipArchive::CREATE) === TRUE) {
                // Add important directories
                $this->addDirectoryToZip($zip, base_path('app'), 'app');
                $this->addDirectoryToZip($zip, base_path('config'), 'config');
                $this->addDirectoryToZip($zip, base_path('database'), 'database');
                $this->addDirectoryToZip($zip, base_path('resources'), 'resources');
                $this->addDirectoryToZip($zip, base_path('routes'), 'routes');
                
                // Add important files
                $importantFiles = ['.env', 'composer.json', 'composer.lock'];
                foreach ($importantFiles as $file) {
                    if (File::exists(base_path($file))) {
                        $zip->addFile(base_path($file), $file);
                    }
                }
                
                $zip->close();
                
                return response()->json([
                    'success' => true,
                    'backup_name' => $backupName,
                    'backup_size' => $this->formatBytes(filesize($backupPath))
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'Failed to create backup'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Add directory to zip recursively
     *
     * @param ZipArchive $zip
     * @param string $dir
     * @param string $zipPath
     */
    private function addDirectoryToZip($zip, $dir, $zipPath)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $zipPath . '/' . substr($filePath, strlen($dir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
    
    /**
     * Download and prepare update
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function installUpdate(Request $request)
    {
        set_time_limit(300); // 5 minutes
        
        $downloadUrl = $request->input('download_url');
        $version = $request->input('version');
        
        try {
            // Download update
            $updateDir = storage_path('app/updates');
            $tempFile = $updateDir . '/update_' . $version . '.zip';
            
            if (!File::exists($updateDir)) {
                File::makeDirectory($updateDir, 0755, true);
            }
            
            $response = Http::timeout(120)->get($downloadUrl);
            
            if ($response->successful()) {
                File::put($tempFile, $response->body());
                
                // Create update instructions
                $instructions = $this->createUpdateInstructions($version, $tempFile);
                
                // Create a simple update command file
                $this->createUpdateCommand($version, $tempFile);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Update prepared successfully!',
                    'version' => $version
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to download update'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Create update instructions
     *
     * @param string $version
     * @param string $zipFile
     * @return string
     */
    private function createUpdateInstructions($version, $zipFile)
    {
        $basePath = base_path();
        
        return "Update has been downloaded. To complete the update, run these commands via SSH:\n\n" .
               "```bash\n" .
               "cd {$basePath}\n" .
               "php artisan down\n" .
               "unzip -o {$zipFile} -d storage/app/updates/\n" .
               "rsync -av --exclude='.env' --exclude='storage/' --exclude='vendor/' --exclude='node_modules/' storage/app/updates/crucipanel2-*/ ./\n" .
               "php artisan migrate --force\n" .
               "php artisan optimize:clear\n" .
               "php artisan settings:restore\n" .
               "php artisan config:cache\n" .
               "php artisan route:cache\n" .
               "php artisan up\n" .
               "rm -rf storage/app/updates/\n" .
               "```\n\n" .
               "After running these commands, refresh this page.";
    }
    
    /**
     * Create update command
     *
     * @param string $version
     * @param string $zipFile
     */
    private function createUpdateCommand($version, $zipFile)
    {
        // Store update info in a file
        $updateInfo = [
            'version' => $version,
            'zip_file' => $zipFile,
            'created_at' => now()->toDateTimeString()
        ];
        
        File::put(storage_path('app/updates/pending.json'), json_encode($updateInfo));
    }
    
    /**
     * Copy update files to project
     *
     * @param string $source
     * @param string $destination
     */
    private function copyUpdateFiles($source, $destination)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $destPath = $destination . '/' . $iterator->getSubPathName();
            
            // Skip certain files/directories
            $skipPaths = ['.env', 'storage/app', 'storage/logs', 'public/uploads', '.git', 'vendor/', 'node_modules/', 'bootstrap/cache/'];
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
    
    /**
     * Run post-update tasks
     */
    private function runPostUpdateTasks()
    {
        // Clear all caches first
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        
        // Clear compiled classes
        if (File::exists(base_path('bootstrap/cache/compiled.php'))) {
            File::delete(base_path('bootstrap/cache/compiled.php'));
        }
        if (File::exists(base_path('bootstrap/cache/services.php'))) {
            File::delete(base_path('bootstrap/cache/services.php'));
        }
        if (File::exists(base_path('bootstrap/cache/packages.php'))) {
            File::delete(base_path('bootstrap/cache/packages.php'));
        }
        
        // Run migrations
        Artisan::call('migrate', ['--force' => true]);
        
        // Optimize autoloader
        Artisan::call('optimize:clear');
        
        // Rebuild caches (but not view:cache as it can cause issues)
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        
        // Clear opcache if available
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        // Clean up old backups (keep only the last 2)
        try {
            Artisan::call('backup:cleanup', ['--keep' => 2]);
            \Log::info('Backup cleanup completed after update');
        } catch (\Exception $e) {
            \Log::warning('Failed to run backup cleanup: ' . $e->getMessage());
        }
    }
    
    /**
     * Update version in config file
     *
     * @param string $version
     */
    private function updateVersionConfig($version)
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
    
    /**
     * Format bytes to human readable
     *
     * @param int $bytes
     * @return string
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}