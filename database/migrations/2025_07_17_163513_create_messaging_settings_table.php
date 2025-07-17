<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messaging_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('messaging_enabled')->default(true);
            $table->boolean('profile_wall_enabled')->default(true);
            $table->integer('message_rate_limit')->default(10); // messages per hour
            $table->integer('wall_message_rate_limit')->default(5); // wall posts per hour
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('messaging_settings')->insert([
            'messaging_enabled' => true,
            'profile_wall_enabled' => true,
            'message_rate_limit' => 10,
            'wall_message_rate_limit' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messaging_settings');
    }
};
