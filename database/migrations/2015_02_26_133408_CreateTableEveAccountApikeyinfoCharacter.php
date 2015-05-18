<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveAccountApikeyinfoCharacter extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_account_apikeyinfo_characters', function (Blueprint $table) {
            $table->increments('id');
          // Id for the many to one relationship from class
          // EveAccountAPIKeyInfo
            $table->integer('keyID')->unsigned();
            $table->integer('characterID')->unsigned();
            $table->string('characterName');
            $table->integer('corporationID')->unsigned();
            $table->string('corporationName');
            $table->index('keyID');
            $table->index('characterID');
            $table->index('characterName');
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
        Schema::dropIfExists('eve_account_apikeyinfo_characters');
    }
}
