<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsInRowsPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rows_places', function (Blueprint $table) {
            $table->double('cx', 8, 2);
            $table->double('cy', 8, 2);
            $table->double('x', 8, 2);
            $table->double('y', 8, 2);
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
            $table->dropColumn('cx');
            $table->dropColumn('cy');
            $table->dropColumn('x');
            $table->dropColumn('y');
        
        });
    }
}
