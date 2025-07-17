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
        Schema::create('profile_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('profile_user_id');
            $table->integer('sender_id');
            $table->text('message');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('profile_user_id')->references('ID')->on('users')->onDelete('cascade');
            $table->foreign('sender_id')->references('ID')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index(['profile_user_id', 'is_visible']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_messages');
    }
};
