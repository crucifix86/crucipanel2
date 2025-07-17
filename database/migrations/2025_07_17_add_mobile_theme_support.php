<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileThemeSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add is_mobile_theme column to themes table
        Schema::table('themes', function (Blueprint $table) {
            $table->boolean('is_mobile_theme')->default(false)->after('is_auth_theme');
        });
        
        // Add mobile_theme_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('mobile_theme_id')->nullable()->after('theme_id');
            $table->foreign('mobile_theme_id')->references('id')->on('themes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['mobile_theme_id']);
            $table->dropColumn('mobile_theme_id');
        });
        
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('is_mobile_theme');
        });
    }
}