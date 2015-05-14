<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCRESTIndustryFacilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crest_industry_facilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facilityID');
            $table->string('stationName', 50);
            $table->integer('ownerID')->unsigned();
            $table->integer('regionID')->nullalble()->default(null)->unsigned();
            $table->integer('solarSystemID')->nullalble()->default(null)->unsigned();
            $table->integer('stationType')->unsigned();
            $table->float('tax')->nullable()->default(null);
            // Index
            $table->index('facilityID');
            $table->index('ownerID');
            $table->index('regionID');
            $table->index('solarSystemID');
            $table->index('stationType');
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
        Schema::dropIfExists('crest_industry_facilities');
    }
}
