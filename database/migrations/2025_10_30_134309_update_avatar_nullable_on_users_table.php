<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('avatar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->string('avatar')->nullable(false)->change();
        });
    }
};
