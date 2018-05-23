<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeasonsIdToPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->integer('season_id')->unsigned();
            $table->foreign('season_id')->references('id')->on('seasons');
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
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
    }
}
