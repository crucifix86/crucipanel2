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
        Schema::create('faction_icons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('faction_id');
            $table->unsignedInteger('server_id')->default(1);
            $table->string('icon_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedInteger('uploaded_by');
            $table->unsignedInteger('approved_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->unsignedInteger('cost_virtual')->default(0);
            $table->unsignedInteger('cost_gold')->default(0);
            $table->boolean('payment_processed')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('faction_id');
            $table->index('status');
            $table->index('uploaded_by');
            $table->index('approved_by');
            $table->unique(['faction_id', 'server_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faction_icons');
    }
};