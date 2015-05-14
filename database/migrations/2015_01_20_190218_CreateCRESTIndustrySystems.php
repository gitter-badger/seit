<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCRESTIndustrySystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crest_industry_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('solarSystemID')->unique()->unsigned();
            $table->double('copyIndex')->unsigned();
            $table->double('inventionIndex')->unsigned();
            $table->double('manufacturingIndex')->unsigned();
            $table->double('meResearchIndex')->unsigned();
            $table->double('reverseIndex')->unsigned();
            $table->double('teResearchIndex')->unsigned();
            // Index
            $table->index('solarSystemID');
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
        Schema::dropIfExists('crest_industry_systems');
    }
}
