<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterSheetJumpcloneImplants extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_character_sheet_jumpclone_implants', function (Blueprint $table) {
            $table->increments('id');
          // Id for the many to one relationship from class
          // EveEveCharacterCharacterSheetJumpClones
            $table->integer('jumpCloneID');
            $table->integer('characterID');
            $table->integer('typeID');
            $table->string('typeName');
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
        Schema::dropIfExists('eve_character_sheet_jumpclone_implants');
    }
}
