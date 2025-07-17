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
        // Delete the Perfect World Classic theme
        Theme::where('name', 'perfect-world-classic')->delete();
        
        // Delete the CSS file if it exists
        $cssPath = public_path('css/themes/theme-perfect-world-classic.css');
        if (file_exists($cssPath)) {
            unlink($cssPath);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We can't restore the theme in down() as we don't have the data
    }
};