<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveAccountApikeyinfo extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_account_apikeyinfo', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('keyID')->unsigned();
            $table->integer('accessMask')->unsigned();
            $table->enum('type', array('Account','Character','Corporation'));
            $table->dateTime('expires')->nullable();
            $table->index('keyID');
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
        Schema::dropIfExists('eve_account_apikeyinfo');
    }
}
