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
        Schema::table('header_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('header_settings', 'content')) {
                $table->text('content')->nullable()->after('badge_logo');
            }
            if (!Schema::hasColumn('header_settings', 'alignment')) {
                $table->string('alignment', 20)->default('center')->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            if (Schema::hasColumn('header_settings', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('header_settings', 'alignment')) {
                $table->dropColumn('alignment');
            }
        });
    }
};