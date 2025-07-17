<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;
use Illuminate\Support\Facades\File;

class DeleteTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:delete {name? : The theme name to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a theme (cannot delete default theme)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        
        if (!$name) {
            // Show list of themes
            $themes = Theme::where('is_default', false)->get();
            
            if ($themes->isEmpty()) {
                $this->info('No themes available to delete (cannot delete default theme).');
                return 0;
            }
            
            $this->info('Available themes to delete:');
            foreach ($themes as $theme) {
                $this->info("  - {$theme->name} ({$theme->display_name})");
            }
            
            $name = $this->ask('Enter the theme name to delete');
        }
        
        $theme = Theme::where('name', $name)->first();
        
        if (!$theme) {
            $this->error("Theme '{$name}' not found!");
            return 1;
        }
        
        if ($theme->is_default) {
            $this->error("Cannot delete the default theme!");
            return 1;
        }
        
        // Check if any users are using this theme
        $userCount = $theme->users()->count();
        if ($userCount > 0) {
            if (!$this->confirm("{$userCount} users are using this theme. They will be switched to default. Continue?")) {
                return 0;
            }
            
            // Switch users to default theme
            $defaultTheme = Theme::where('is_default', true)->first();
            $theme->users()->update(['theme_id' => $defaultTheme->id]);
        }
        
        // Delete the CSS file
        $fileName = 'theme-' . $theme->name . '.css';
        $filePath = public_path('css/themes/' . $fileName);
        
        if (File::exists($filePath)) {
            File::delete($filePath);
            $this->info("Deleted CSS file: {$fileName}");
        }
        
        // Delete the theme
        $displayName = $theme->display_name;
        $theme->delete();
        
        $this->info("Theme '{$displayName}' has been deleted successfully!");
        
        return 0;
    }
}