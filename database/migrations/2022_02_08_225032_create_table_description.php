<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description', function (Blueprint $table) {
            $table->integer('id');
            $table->string("address");
            $table->string("latitude");
            $table->string("longitude");
            $table->string("date");
            $table->string("description");
            $table->string("hour");
            $table->string("tour");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('description');
    }
}
