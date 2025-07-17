<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRewardedAtToArenalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pwp_arenalogs', function (Blueprint $table) {
            $table->timestamp('rewarded_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pwp_arenalogs', function (Blueprint $table) {
            $table->dropColumn('rewarded_at');
        });
    }
}