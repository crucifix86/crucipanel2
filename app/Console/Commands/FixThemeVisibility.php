<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Theme;

class FixThemeVisibility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themes:fix-visibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make all themes visible (fixes themes that were cloned without visibility)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $themes = Theme::where('is_visible', false)->get();
        
        if ($themes->count() === 0) {
            $this->info('All themes are already visible!');
            return 0;
        }
        
        $this->info('Found ' . $themes->count() . ' hidden themes. Making them visible...');
        
        foreach ($themes as $theme) {
            $theme->is_visible = true;
            $theme->save();
            $this->info('Made visible: ' . $theme->display_name);
        }
        
        $this->info('All themes are now visible!');
        return 0;
    }
}