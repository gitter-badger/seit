<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveAccountAccountstatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_account_accountstatus', function(Blueprint $table) {
            $table->increments('id');
          // Id for the one to one relationship from class
          // EveAccountAPIKeyInfo
            $table->integer('keyID')->unsigned();
            $table->dateTime('paidUntil');
            $table->dateTime('createDate');
            $table->integer('logonCount')->unsigned();
            $table->integer('logonMinutes')->unsigned();
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
        Schema::dropIfExists('eve_account_accountstatus');
    }
}
