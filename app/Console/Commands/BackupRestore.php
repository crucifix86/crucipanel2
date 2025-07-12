<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;

class BackupRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore {backup? : The backup ZIP file name to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the application from a backup ZIP file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            $this->error('No backups directory found at: ' . $backupPath);
            return 1;
        }
        
        $backupName = $this->argument('backup');
        
        if (!$backupName) {
            // List available backups
            $backups = File::files($backupPath);
            $zipBackups = [];
            
            foreach ($backups as $backup) {
                if (pathinfo($backup, PATHINFO_EXTENSION) === 'zip') {
                    $zipBackups[] = basename($backup);
                }
            }
            
            if (empty($zipBackups)) {
                $this->error('No backup ZIP files found.');
                return 1;
            }
            
            // Sort by date (newest first)
            rsort($zipBackups);
            
            $this->info('Available backups:');
            foreach ($zipBackups as $index => $backup) {
                $size = $this->formatBytes(filesize($backupPath . '/' . $backup));
                $date = $this->extractDateFromBackupName($backup);
                $this->line(sprintf('%d. %s (%s) - %s', $index + 1, $backup, $size, $date));
            }
            
            $choice = $this->ask('Enter the number of the backup to restore');
            
            if (!is_numeric($choice) || $choice < 1 || $choice > count($zipBackups)) {
                $this->error('Invalid choice.');
                return 1;
            }
            
            $backupName = $zipBackups[$choice - 1];
        }
        
        $backupFile = $backupPath . '/' . $backupName;
        
        if (!File::exists($backupFile)) {
            $this->error("Backup file '{$backupName}' not found.");
            return 1;
        }
        
        $this->warn("WARNING: This will restore the application from backup: {$backupName}");
        $this->warn("Current application state will be overwritten!");
        
        if (!$this->confirm('Do you want to continue?')) {
            $this->info('Restore cancelled.');
            return 0;
        }
        
        $this->info('Starting restore process...');
        
        try {
            // Create temporary extraction directory
            $tempDir = storage_path('app/temp_restore_' . time());
            File::makeDirectory($tempDir, 0755, true);
            
            // Extract backup
            $zip = new ZipArchive();
            if ($zip->open($backupFile) === TRUE) {
                $zip->extractTo($tempDir);
                $zip->close();
                $this->info('✓ Extracted backup file');
            } else {
                throw new \Exception('Failed to open backup ZIP file');
            }
            
            // Put site in maintenance mode
            Artisan::call('down');
            $this->info('✓ Site is now in maintenance mode');
            
            // Restore directories
            $this->restoreDirectory($tempDir . '/app', app_path(), 'app');
            $this->restoreDirectory($tempDir . '/config', config_path(), 'config');
            $this->restoreDirectory($tempDir . '/database', database_path(), 'database');
            $this->restoreDirectory($tempDir . '/resources', resource_path(), 'resources');
            $this->restoreDirectory($tempDir . '/routes', base_path('routes'), 'routes');
            
            // Restore important files (except .env to preserve current database settings)
            if (File::exists($tempDir . '/composer.json')) {
                File::copy($tempDir . '/composer.json', base_path('composer.json'));
                $this->info('✓ Restored composer.json');
            }
            
            if (File::exists($tempDir . '/composer.lock')) {
                File::copy($tempDir . '/composer.lock', base_path('composer.lock'));
                $this->info('✓ Restored composer.lock');
            }
            
            // Clean up temp directory
            File::deleteDirectory($tempDir);
            $this->info('✓ Cleaned up temporary files');
            
            // Clear all caches
            $this->info('Clearing caches...');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            // Clear compiled files
            $compiledPath = base_path('bootstrap/cache');
            foreach (['compiled.php', 'services.php', 'packages.php'] as $file) {
                if (File::exists($compiledPath . '/' . $file)) {
                    File::delete($compiledPath . '/' . $file);
                }
            }
            
            // Rebuild caches
            $this->info('Rebuilding caches...');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            
            // Fix permissions
            $this->info('Fixing permissions...');
            exec('chmod -R 755 ' . storage_path());
            exec('chmod -R 755 ' . base_path('bootstrap/cache'));
            
            // Bring site back online
            Artisan::call('up');
            $this->info('✓ Site is back online');
            
            $this->info('');
            $this->info('✓ Restore completed successfully!');
            $this->info('Backup restored: ' . $backupName);
            $this->info('');
            $this->warn('Note: The .env file was NOT restored to preserve your current database settings.');
            $this->warn('If you need to restore .env settings, you can extract them from the backup manually.');
            
            return 0;
            
        } catch (\Exception $e) {
            // Try to bring site back online if restore failed
            Artisan::call('up');
            
            $this->error('Restore failed: ' . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Restore a directory from backup
     *
     * @param string $source
     * @param string $destination
     * @param string $name
     */
    private function restoreDirectory($source, $destination, $name)
    {
        if (File::exists($source)) {
            // Remove existing directory
            if (File::exists($destination)) {
                File::deleteDirectory($destination);
            }
            
            // Copy from backup
            File::copyDirectory($source, $destination);
            $this->info('✓ Restored ' . $name . ' directory');
        }
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
    
    /**
     * Extract date from backup filename
     *
     * @param string $filename
     * @return string
     */
    private function extractDateFromBackupName($filename)
    {
        // Format: backup_2024-01-15_14-30-45.zip
        if (preg_match('/backup_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})\.zip/', $filename, $matches)) {
            $dateStr = str_replace('_', ' ', $matches[1]);
            $dateStr = str_replace('-', ':', substr($dateStr, 11));
            return $dateStr;
        }
        
        return 'Unknown date';
    }
}