<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal');
            $table->integer('cliente');
            $table->string('endHour');
            $table->string('startAddress');
            $table->string('startHour');
            $table->string('startLocationLatitude');
            $table->string('startLocationLongitude');
            $table->string('endLocationLatitude');
            $table->string('endLocationLongitude');
            $table->string('endHours');
            $table->integer('description');
            $table->integer('tour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
