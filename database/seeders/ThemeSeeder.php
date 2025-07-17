<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read existing theme files
        $cssContent = file_get_contents(public_path('css/mystical-purple-unified.css'));
        $jsContent = file_get_contents(public_path('js/mystical-purple-unified.js'));
        $layoutContent = file_get_contents(resource_path('views/layouts/mystical.blade.php'));

        // Create default mystical theme (non-editable safety version)
        Theme::create([
            'name' => 'default-mystical',
            'display_name' => 'Default Mystical (Safety)',
            'description' => 'The original mystical purple theme. This is the safety version that cannot be edited.',
            'css_content' => $cssContent,
            'js_content' => $jsContent,
            'layout_content' => $layoutContent,
            'is_active' => true,
            'is_visible' => true,
            'is_default' => true,
            'is_editable' => false
        ]);

        // Create editable copy for users
        Theme::create([
            'name' => 'custom-mystical',
            'display_name' => 'Custom Mystical',
            'description' => 'Your customizable mystical theme. Edit this to create your own unique style.',
            'css_content' => $cssContent,
            'js_content' => $jsContent,
            'layout_content' => $layoutContent,
            'is_active' => false,
            'is_visible' => true,
            'is_default' => false,
            'is_editable' => true
        ]);
    }
}
