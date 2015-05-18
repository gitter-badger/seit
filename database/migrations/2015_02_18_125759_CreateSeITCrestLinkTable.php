<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeITCrestLinkTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seit_crestlink', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->integer('characterID')->unsigned();
            $table->string('characterName');
            $table->string('characterOwnerHash');
            $table->string('scopes');
            $table->string('tokenType');
            $table->timestamp('expires');
            $table->timestamps();
            $table->softDeletes();
            $table->index('userID');
            $table->index('characterID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seit_crestlink');
    }
}
