<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotNullInPerformances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('genre')->nullable(false)->change();
            $table->string('duration')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('author')->nullable(false)->change();
            $table->string('age_restrict')->nullable(false)->change();
            $table->string('photo_main')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->string('name')->nullable(true)->change();
            $table->string('genre')->nullable(true)->change();
            $table->string('duration')->nullable(true)->change();
            $table->text('description')->nullable(true)->change();
            $table->string('author')->nullable(true)->change();
            $table->string('age_restrict')->nullable(true)->change();
            $table->string('photo_main')->nullable(true)->change();
        });
    }
}
