<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRowsPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rows_places', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('row_id', false)->unsigned();
            $table->integer('place_id', false)->unsigned();;
            $table->integer('category_id', false)->unsigned();
            $table->foreign('category_id')->references('id')->on('category_places');
            $table->primary(['id', 'row_id', 'place_id', 'category_id']);
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rows_places');
    }
}
