<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->string('footer_image')->nullable()->after('alignment');
            $table->string('footer_image_link')->nullable()->after('footer_image');
            $table->string('footer_image_alt')->nullable()->after('footer_image_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn(['footer_image', 'footer_image_link', 'footer_image_alt']);
        });
    }
};
