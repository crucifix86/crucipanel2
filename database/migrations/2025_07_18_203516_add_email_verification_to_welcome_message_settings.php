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
        Schema::table('welcome_message_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('welcome_message_settings', 'email_verification_enabled')) {
                $table->boolean('email_verification_enabled')->default(true)->after('reward_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('welcome_message_settings', function (Blueprint $table) {
            if (Schema::hasColumn('welcome_message_settings', 'email_verification_enabled')) {
                $table->dropColumn('email_verification_enabled');
            }
        });
    }
};
