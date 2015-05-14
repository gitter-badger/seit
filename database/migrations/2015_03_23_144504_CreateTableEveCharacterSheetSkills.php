<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCharacterSheetSkills extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_character_sheet_skills', function(Blueprint $table) {
            $table->increments('id');
            // Id for the many to one relationship from class
            // EveEveCharacterInfo
            $table->integer('characterID');
            $table->integer('typeID');
            $table->integer('skillpoints');
            $table->integer('level');
            $table->integer('published');
            // Indexes
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
        Schema::dropIfExists('eve_character_sheet_skills');
    }
}
