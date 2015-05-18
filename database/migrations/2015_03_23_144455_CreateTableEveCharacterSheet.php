<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterSheet extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_character_sheet', function (Blueprint $table) {
            $table->increments('id');

            // Id for the many to one relationship from class
            // EveEveCharacterInfo
            $table->integer('characterID');
            $table->string('name');
            $table->dateTime('DoB');
            $table->string('race');
            $table->string('bloodLine');
            $table->string('ancestry');
            $table->string('gender');
            $table->string('corporationName');
            $table->integer('corporationID');
            $table->integer('factionID')->nullable();
            $table->string('factionName')->nullable();
            // Some rich bastards out there
            $table->decimal('balance', 22, 2)->nullable();
            
            // Really dont see why we need to make another table just for these attribs.
            // Soooo, just gonna slap 'em in here.
            $table->integer('intelligence');
            $table->integer('memory');
            $table->integer('charisma');
            $table->integer('perception');
            $table->integer('willpower');
            $table->dateTime('jumpActivation');
            $table->dateTime('jumpFatigue');
            $table->dateTime('jumpLastUpdate');
            $table->dateTime('remoteStationDate');
            $table->dateTime('lastTimedRespec');
            $table->dateTime('lastRespecDate');
            $table->dateTime('cloneJumpDate');
            $table->integer('freeRespecs');
            $table->integer('homeStationID');

            // Index
            $table->index('characterID');
            $table->index('name');

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
        Schema::dropIfExists('eve_character_sheet');
    }
}
