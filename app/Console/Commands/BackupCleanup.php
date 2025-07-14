<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:cleanup {--keep=2 : Number of backups to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old backups, keeping only the most recent ones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keepCount = (int) $this->option('keep');
        
        if ($keepCount < 1) {
            $this->error('Must keep at least 1 backup.');
            return 1;
        }
        
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            $this->info('No backups directory found. Nothing to clean up.');
            return 0;
        }
        
        // Get all backup files
        $backups = File::files($backupPath);
        $zipBackups = [];
        
        foreach ($backups as $backup) {
            if (pathinfo($backup, PATHINFO_EXTENSION) === 'zip') {
                $zipBackups[] = [
                    'path' => $backup->getPathname(),
                    'name' => $backup->getFilename(),
                    'time' => $backup->getMTime(),
                    'size' => $backup->getSize()
                ];
            }
        }
        
        if (count($zipBackups) <= $keepCount) {
            $this->info(sprintf('Found %d backup(s). No cleanup needed (keeping %d).', count($zipBackups), $keepCount));
            return 0;
        }
        
        // Sort by modification time (newest first)
        usort($zipBackups, function($a, $b) {
            return $b['time'] - $a['time'];
        });
        
        // Determine which backups to delete
        $toDelete = array_slice($zipBackups, $keepCount);
        
        if (empty($toDelete)) {
            $this->info('No backups to delete.');
            return 0;
        }
        
        $this->info(sprintf('Found %d backup(s). Will delete %d old backup(s), keeping the %d most recent.', 
            count($zipBackups), count($toDelete), $keepCount));
        
        $this->info('');
        $this->info('Backups to keep:');
        for ($i = 0; $i < $keepCount && $i < count($zipBackups); $i++) {
            $this->line(sprintf('  ✓ %s (%s) - %s', 
                $zipBackups[$i]['name'],
                $this->formatBytes($zipBackups[$i]['size']),
                date('Y-m-d H:i:s', $zipBackups[$i]['time'])
            ));
        }
        
        $this->info('');
        $this->info('Backups to delete:');
        $totalSize = 0;
        foreach ($toDelete as $backup) {
            $this->line(sprintf('  ✗ %s (%s) - %s', 
                $backup['name'],
                $this->formatBytes($backup['size']),
                date('Y-m-d H:i:s', $backup['time'])
            ));
            $totalSize += $backup['size'];
        }
        
        $this->info('');
        $this->info(sprintf('This will free up %s of disk space.', $this->formatBytes($totalSize)));
        
        if (!$this->confirm('Do you want to proceed with cleanup?')) {
            $this->info('Cleanup cancelled.');
            return 0;
        }
        
        // Delete old backups
        $deletedCount = 0;
        foreach ($toDelete as $backup) {
            try {
                File::delete($backup['path']);
                $deletedCount++;
                $this->info('Deleted: ' . $backup['name']);
            } catch (\Exception $e) {
                $this->error('Failed to delete: ' . $backup['name'] . ' - ' . $e->getMessage());
            }
        }
        
        $this->info('');
        $this->info(sprintf('✓ Cleanup completed. Deleted %d backup(s), freed %s.', 
            $deletedCount, $this->formatBytes($totalSize)));
        
        return 0;
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