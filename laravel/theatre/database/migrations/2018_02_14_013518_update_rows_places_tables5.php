<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRowsPlacesTables5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rows_places', function (Blueprint $table) {
            //$table->integer('id', true)->unsigned()->unique();
            $table->integer('row_id', false)->unsigned();
            $table->integer('place_id', false)->unsigned();;
            $table->integer('category_id', false)->unsigned();
            $table->foreign('category_id')->references('id')->on('category_places');
            $table->integer('stage_id')->unsigned();
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->primary(['row_id', 'place_id', 'category_id', 'stage_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rows_places', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['stage_id']); 
            $table->dropColumn(['row_id', 'place_id', 'category_id','stage_id']);
            
        });
    }
}
