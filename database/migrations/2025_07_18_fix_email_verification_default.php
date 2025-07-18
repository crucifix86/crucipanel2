<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set email verification to disabled by default
        DB::table('welcome_message_settings')
            ->update(['email_verification_enabled' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set it back to enabled
        DB::table('welcome_message_settings')
            ->update(['email_verification_enabled' => true]);
    }
};