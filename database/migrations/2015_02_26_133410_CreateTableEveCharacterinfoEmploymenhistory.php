<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterinfoEmploymenhistory extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_characterinfo_employmenthistory', function (Blueprint $table) {
            $table->increments('id');
          // Id for the many to one relationship from class
          // EveEveCharacterInfo
            $table->integer('characterID')->unsigned();
            $table->integer('recordID')->unsigned();
            $table->integer('corporationID')->unsigned();
            $table->dateTime('startDate');
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
        Schema::dropIfExists('eve_characterinfo_employmenthistory');
    }
}
