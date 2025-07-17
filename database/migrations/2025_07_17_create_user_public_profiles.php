<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('public_bio')->nullable()->after('email');
            $table->string('public_discord', 100)->nullable()->after('public_bio');
            $table->string('public_website', 255)->nullable()->after('public_discord');
            $table->boolean('public_profile_enabled')->default(true)->after('public_website');
            $table->boolean('public_wall_enabled')->default(true)->after('public_profile_enabled');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'public_bio',
                'public_discord',
                'public_website',
                'public_profile_enabled',
                'public_wall_enabled'
            ]);
        });
    }
};