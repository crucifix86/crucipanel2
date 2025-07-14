<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeOgImageNullableInNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pwp_news', function (Blueprint $table) {
            $table->string('og_image')->nullable()->change();
            
            // Add slug field if it doesn't exist
            if (!Schema::hasColumn('pwp_news', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pwp_news', function (Blueprint $table) {
            $table->string('og_image')->nullable(false)->change();
            
            // Remove slug field if we added it
            if (Schema::hasColumn('pwp_news', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
}