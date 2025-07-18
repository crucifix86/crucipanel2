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
        Schema::create('faction_icon_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->unsignedInteger('icon_size')->default(24); // 24x24 pixels
            $table->unsignedInteger('max_file_size')->default(204800); // 200KB in bytes
            $table->unsignedInteger('cost_virtual')->default(0);
            $table->unsignedInteger('cost_gold')->default(100000); // 10 gold
            $table->boolean('require_approval')->default(true);
            $table->boolean('auto_deploy')->default(false);
            $table->json('allowed_formats')->default('["png","jpg","jpeg","gif"]');
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('faction_icon_settings')->insert([
            'enabled' => true,
            'icon_size' => 24,
            'max_file_size' => 204800,
            'cost_virtual' => 0,
            'cost_gold' => 100000,
            'require_approval' => true,
            'auto_deploy' => false,
            'allowed_formats' => json_encode(['png', 'jpg', 'jpeg', 'gif']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faction_icon_settings');
    }
};