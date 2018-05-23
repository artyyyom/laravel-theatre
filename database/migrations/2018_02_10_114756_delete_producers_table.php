<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('producers', function (Blueprint $table) {
            Schema::dropIfExists('producers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname');
            $table->string('name');
            $table->string('middlename');
            $table->string('address');
            $table->date('birthday');
            $table->text('biography');
            $table->string('phone_number');
            $table->string('biography_short');
            $table->string('photo_main');
            $table->text('photos');
            $table->timestamps();
        });
    }
}
