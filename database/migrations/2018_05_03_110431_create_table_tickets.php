<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('row_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->foreign(['row_id', 'place_id'])->references(['row_id', 'place_id'])->on('rows_places');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('category_id')->on('rows_places');
            $table->integer('seance_id');
            $table->foreign('seance_id')->references('id')->on('seances');
            $table->integer('price');
            $table->boolean('is_avalaible')->default(false);
            $table->boolean('status')->default(0);
            $table->primary(['place_id', 'row_id', 'category_id', 'seance_id']);
            $table->timestamps();
        });
        DB::statement('ALTER Table tickets add id INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
