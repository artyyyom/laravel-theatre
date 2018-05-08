<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePrimaryKeysFromTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->primary('id');
            $table->dropPrimary('place_id');
            $table->dropPrimary('row_id');
            $table->dropPrimary('category_id');
            $table->dropPrimary('seance_id');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->primary(['place_id', 'row_id', 'category_id', 'seance_id']);
        });
    }
}
