<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePerformancesActorsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances_actors', function (Blueprint $table) {
            if (Schema::hasTable('performances_actors')) {
                Schema::rename('performances_actors', 'performances_employees');
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
        Schema::table('performances_actors', function (Blueprint $table) {
            Schema::rename('performances_employees', 'performances_actors');
            
        });
    }
}
