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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('recipient_id');
            $table->string('subject', 255)->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('deleted_by_sender')->default(false);
            $table->boolean('deleted_by_recipient')->default(false);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('sender_id')->references('ID')->on('users')->onDelete('cascade');
            $table->foreign('recipient_id')->references('ID')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('messages')->onDelete('cascade');
            
            // Indexes
            $table->index(['recipient_id', 'is_read']);
            $table->index('sender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
