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
        Schema::create('welcome_message_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('subject')->default('Welcome to our server!');
            $table->text('message');
            $table->boolean('reward_enabled')->default(true);
            $table->enum('reward_type', ['virtual', 'cubi', 'bonus'])->default('virtual');
            $table->integer('reward_amount')->default(1000);
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('welcome_message_settings')->insert([
            'enabled' => true,
            'subject' => 'Welcome to our server!',
            'message' => "Welcome to our server!\n\nWe're excited to have you join our community. This message contains a special reward for new players.\n\nMake sure to read our rules and guidelines, and don't hesitate to ask for help if you need it.\n\nEnjoy your stay!",
            'reward_enabled' => true,
            'reward_type' => 'virtual',
            'reward_amount' => 1000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_message_settings');
    }
};