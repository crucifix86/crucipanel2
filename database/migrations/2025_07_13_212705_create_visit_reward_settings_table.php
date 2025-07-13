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
        Schema::create('visit_reward_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->integer('reward_amount')->default(10);
            $table->enum('reward_type', ['virtual', 'cubi', 'bonuses'])->default('virtual');
            $table->integer('cooldown_hours')->default(24); // How many hours between claims
            $table->string('title')->default('Daily Visit Reward');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_reward_settings');
    }
};
