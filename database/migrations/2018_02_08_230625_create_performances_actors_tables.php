<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesActorsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances_actors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performance_id')->unsigned();
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->integer('actor_id')->unsigned();
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->string('role');
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
        Schema::dropIfExists('performances_actors');
    }
}
