<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityNamesMap extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seit_entity_names_map', function (Blueprint $table) {
            $table->increments('id');
            $table->text('entityName')->default(null)->nullable();
            $table->integer('entityID')->unsigned();
            $table->boolean('resolved')->default(false);
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
        Schema::drop('seit_entity_names_map');
    }
}
