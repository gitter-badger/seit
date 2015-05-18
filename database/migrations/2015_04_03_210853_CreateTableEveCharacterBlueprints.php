<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterBlueprints extends Migration
{

/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_character_blueprints', function (Blueprint $table) {
            $table->increments('id');
            // Id for the many to one relationship from class
            // EveEveCharacterCharacterSheet
            $table->integer('characterID');
            $table->bigInteger('itemID')->unsigned();
            $table->bigInteger('locationID')->unsigned();
            $table->integer('typeID');
            $table->integer('flagID');
            $table->integer('quantity');
            $table->integer('timeEfficiency')->unsigned()->default(0);
            $table->integer('materialEfficiency')->unsigned()->default(0);
            $table->integer('runs')->default(0);
            $table->timestamps();
            $table->softDeletes();
            // indexes
            $table->index('characterID');
            $table->index('itemID');
            $table->index('locationID');
            $table->index('typeID');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eve_character_blueprints');
    }
}
