<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->date('date');
            $table->time('time');
            $table->integer('performance_id')->unsigned();
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->integer('stage_id')->unsigned();
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->primary(['stage_id','date', 'time']);
            $table->timestamps();
        });
        DB::statement('ALTER Table seances add id INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
