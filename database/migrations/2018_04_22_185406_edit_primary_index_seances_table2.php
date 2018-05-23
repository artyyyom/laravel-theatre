<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPrimaryIndexSeancesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->integer('performance_id')->unsigned();
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->integer('stage_id')->unsigned();
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->primary(['performance_id', 'stage_id']);
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
        Schema::table('seances', function (Blueprint $table) {
            //
        });
    }
}
