<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePerformancesEmployeesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances_employees', function (Blueprint $table) {
            if (Schema::hasTable('performances_employees')) {
                $table->dropForeign('performances_actors_actor_id_foreign');
                $table->dropColumn('actor_id');
                 $table->dropForeign('performances_actors_performance_id_foreign');
                $table->integer('employee_id')->unsigned();
                $table->foreign('employee_id')->references('id')->on('employees');
                $table->foreign('performance_id')->references('id')->on('performances');
            $table->foreign('performance_id')->references('id')->on('performances');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('performances_employees', function (Blueprint $table) {
            //
        });
    }
}
