<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class MobileThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read the mobile theme CSS
        $mobileCss = file_get_contents(public_path('css/themes/theme-mobile-mystical.css'));
        
        // Create or update the mobile theme
        Theme::updateOrCreate(
            ['name' => 'mobile-mystical'],
            [
                'display_name' => 'Mobile Mystical',
                'description' => 'Clean and responsive theme optimized for mobile devices',
                'css_content' => $mobileCss,
                'js_content' => '// Mobile-specific JavaScript can go here',
                'layout_content' => '',
                'is_active' => true,
                'is_visible' => true,
                'is_default' => false,
                'is_auth_theme' => false,
                'is_mobile_theme' => true,
                'is_editable' => true
            ]
        );
    }
}