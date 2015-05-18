<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveConquerablestationlist extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_conquerablestationlist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stationID')->unique()->unsigned();
            $table->string('stationName');
            $table->integer('stationTypeID')->unsigned();
            $table->integer('solarSystemID')->unsigned();
            $table->integer('corporationID')->unsigned();
            $table->string('corporationName');
          // Index
            $table->index('stationID');
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
        Schema::dropIfExists('eve_conquerablestationlist');
    }
}
