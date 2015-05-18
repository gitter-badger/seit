<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterinfo extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_characterinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('characterID')->unique()->unsigned();
            $table->string('characterName');
            $table->string('race');
            $table->string('bloodline');
          // Some columns will only be filled if a key/vcode pair is provided and valid,
          // so make them nullable
            $table->decimal('accountBalance', 22, 2)->nullable();  // Some rich bastards out there
            $table->integer('skillPoints')->nullable()->unsigned();
            $table->dateTime('nextTrainingEnds')->nullable();
            $table->string('shipName')->nullable();
            $table->integer('shipTypeID')->nullable()->unsigned();
            $table->string('shipTypeName')->nullable();
            $table->integer('corporationID')->unsigned();
            $table->string('corporation');
            $table->dateTime('corporationDate');
            $table->integer('allianceID')->nullable()->unsigned();
            $table->string('alliance')->nullable();
            $table->dateTime('allianceDate')->nullable();
            $table->string('lastKnownLocation')->nullable();
            $table->decimal('securityStatus', 20, 13);
          // Index
            $table->index('characterID');
            $table->index('characterName');
            $table->index('securityStatus');
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
        Schema::dropIfExists('eve_characterinfo');
    }
}
