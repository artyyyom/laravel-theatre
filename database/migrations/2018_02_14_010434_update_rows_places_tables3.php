<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRowsPlacesTables3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rows_places', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['id', 'row_id', 'place_id', 'category_id']);
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
            $table->integer('id', true)->unsigned();
            $table->integer('row_id', false)->unsigned();
            $table->integer('place_id', false)->unsigned();;
            $table->integer('category_id', false)->unsigned();
            $table->foreign('category_id')->references('id')->on('category_places');
            $table->primary(['id', 'row_id', 'place_id', 'category_id']);
        });
    }
}
