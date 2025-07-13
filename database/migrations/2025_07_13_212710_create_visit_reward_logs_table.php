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
        Schema::create('visit_reward_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('ip_address', 45);
            $table->integer('reward_amount');
            $table->enum('reward_type', ['virtual', 'cubi', 'bonuses']);
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->foreign('user_id')->references('ID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_reward_logs');
    }
};
