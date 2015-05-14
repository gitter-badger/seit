<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterSheetJumpclone extends Migration
{

/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_character_sheet_jumpclones', function(Blueprint $table) {
            $table->increments('id');
          // Id for the many to one relationship from class
          // EveEveCharacterCharacterSheet
            $table->integer('characterID');
            $table->integer('jumpCloneID');
            $table->integer('typeID');
            $table->bigInteger('locationID');
            $table->string('cloneName')->nullable();
          // Indexes
            $table->index('jumpCloneID');
            $table->index('characterID');
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
        Schema::dropIfExists('eve_character_sheet_jumpclones');
    }
}
