<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->text('public_bio')->nullable();
            $table->string('public_discord', 100)->nullable();
            $table->string('public_website', 255)->nullable();
            $table->boolean('public_profile_enabled')->default(true);
            $table->boolean('public_wall_enabled')->default(true);
            $table->timestamps();
            
            $table->foreign('user_id')->references('ID')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};