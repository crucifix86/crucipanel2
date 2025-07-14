<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_security_settings', function (Blueprint $table) {
            $table->id();
            
            // IP-based limits
            $table->boolean('ip_limit_enabled')->default(true);
            $table->integer('max_votes_per_ip_daily')->default(2);
            $table->integer('max_votes_per_ip_per_site')->default(1);
            
            // Account restrictions
            $table->boolean('account_restrictions_enabled')->default(true);
            $table->integer('min_account_age_days')->default(7);
            $table->integer('min_character_level')->default(0);
            $table->boolean('require_email_verified')->default(true);
            
            // Test mode bypass
            $table->boolean('bypass_in_test_mode')->default(true);
            
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('vote_security_settings')->insert([
            'ip_limit_enabled' => true,
            'max_votes_per_ip_daily' => 2,
            'max_votes_per_ip_per_site' => 1,
            'account_restrictions_enabled' => true,
            'min_account_age_days' => 7,
            'min_character_level' => 0,
            'require_email_verified' => true,
            'bypass_in_test_mode' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_security_settings');
    }
};