<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Theme;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if theme already exists
        if (!Theme::where('name', 'perfect-world-classic')->exists()) {
            // Check if CSS file exists
            $cssPath = public_path('css/themes/theme-perfect-world-classic.css');
            
            // Get JS and layout from default theme
            $defaultTheme = Theme::where('is_default', true)->first();
            
            if ($defaultTheme && file_exists($cssPath)) {
                Theme::create([
                    'name' => 'perfect-world-classic',
                    'display_name' => 'Perfect World Classic',
                    'description' => 'Classic theme based on Perfect World installer',
                    'css_content' => file_get_contents($cssPath),
                    'js_content' => $defaultTheme->js_content,
                    'layout_content' => $defaultTheme->layout_content,
                    'is_active' => false,
                    'is_visible' => true,
                    'is_default' => false,
                    'is_editable' => true,
                    'is_auth_theme' => false
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Theme::where('name', 'perfect-world-classic')->delete();
    }
};