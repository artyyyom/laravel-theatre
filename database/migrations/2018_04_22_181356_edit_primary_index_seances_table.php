<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPrimaryIndexSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->dropForeign('performance_id');
            $table->dropForeign('stage_id');
            $table->dropColumn(['performance_id','stage_id','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performance_id')->unsigned();
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->integer('stage_id')->unsigned();
            $table->foreign('stage_id')->references('id')->on('stages');
        });
    }
}
