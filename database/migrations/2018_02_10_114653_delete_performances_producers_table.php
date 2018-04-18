<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePerformancesProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances_producers', function (Blueprint $table) {
            Schema::dropIfExists('performances_producers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('performances_producers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performance_id')->unsigned();
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->integer('producer_id')->unsigned();
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->timestamps();
        });
    }
}
