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
        // Set charset to match users table
        Schema::connection('mysql')->getConnection()->statement('SET NAMES utf8');
        
        Schema::create('visit_reward_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            
            $table->id();
            $table->integer('user_id');
            $table->string('ip_address', 45);
            $table->integer('reward_amount');
            $table->enum('reward_type', ['virtual', 'cubi', 'bonuses']);
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index('user_id'); // Add explicit index for foreign key
        });
        
        // Add foreign key constraint separately to avoid issues
        Schema::table('visit_reward_logs', function (Blueprint $table) {
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
