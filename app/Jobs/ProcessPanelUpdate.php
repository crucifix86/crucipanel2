<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ProcessPanelUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $version;
    protected $zipFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($version, $zipFile)
    {
        $this->version = $version;
        $this->zipFile = $zipFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Extract update
            $zip = new ZipArchive();
            if ($zip->open($this->zipFile) === TRUE) {
                $extractPath = storage_path('app/temp/extract_' . $this->version);
                $zip->extractTo($extractPath);
                $zip->close();

                // Find the actual project directory
                $dirs = File::directories($extractPath);
                $sourceDir = $dirs[0] ?? $extractPath;

                // Copy files
                $this->copyFiles($sourceDir, base_path());

                // Update version
                $this->updateVersion($this->version);

                // Clean up
                File::deleteDirectory($extractPath);
                File::delete($this->zipFile);

                // Clear caches after update
                Artisan::call('optimize:clear');
            }
        } catch (\Exception $e) {
            \Log::error('Update job failed: ' . $e->getMessage());
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