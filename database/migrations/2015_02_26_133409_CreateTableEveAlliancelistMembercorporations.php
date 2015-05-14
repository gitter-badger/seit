<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveAlliancelistMembercorporations extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_alliancelist', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('shortName');
            $table->integer('allianceID')->unsigned();
            $table->integer('executorCorpID')->unsigned();
            $table->integer('memberCount')->unsigned();
            $table->dateTime('startDate');
          // Indexes
            $table->index('allianceID');
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
        Schema::dropIfExists('eve_alliancelist');
    }
}
