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
        Schema::table('themes', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('is_active');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('theme_id')->nullable()->after('truename');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
            $table->dropColumn('theme_id');
        });
        
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });
    }
};
