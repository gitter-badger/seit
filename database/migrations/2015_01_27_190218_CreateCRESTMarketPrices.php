<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCRESTMarketPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crest_marketprices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('typeID')->unsigned();
            $table->double('adjustedPrice')->unsigned()->nullalble()->default(null);
            $table->double('averagePrice')->unsigned()->nullalble()->default(null);
            // Index
            $table->index('typeID');
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
        Schema::dropIfExists('crest_marketprices');
    }
}
