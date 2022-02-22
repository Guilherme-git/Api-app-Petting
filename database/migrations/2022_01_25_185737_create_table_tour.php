<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour', function (Blueprint $table) {
            $table->increments('id');
            $table->string('startAddress');
            $table->string('startDate');
            $table->string('startHour');
            $table->string('endAddress');
            $table->string('endDate');
            $table->string('endHour');
            $table->string('sent');
            $table->string('status');
            $table->string('startLocationLatitude');
            $table->string('startLocationLongitude');
            $table->string('endLocationLatitude');
            $table->string('endLocationLongitude');
            $table->integer('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour');
    }
}
