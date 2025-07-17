<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // It's good practice to check if the column exists before trying to modify it,
            // though `change()` typically requires the doctrine/dbal package.
            // Assuming 'phonenumber' column exists
            if (Schema::hasColumn('users', 'phonenumber')) {
                $table->string('phonenumber')->nullable()->change();
            }
            // Assuming 'truename' column exists
            if (Schema::hasColumn('users', 'truename')) {
                $table->string('truename')->nullable()->change();
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
        Schema::table('users', function (Blueprint $table) {
            // Reverting to not nullable. This assumes they were string types.
            // If they had specific lengths or other attributes, that would need to be known.
            // For safety, one might choose to make this less destructive or more specific
            // if the original state was complex.
            if (Schema::hasColumn('users', 'phonenumber')) {
                $table->string('phonenumber')->nullable(false)->change();
            }
            if (Schema::hasColumn('users', 'truename')) {
                $table->string('truename')->nullable(false)->change();
            }
        });
    }
};
