<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEveCorporationIndustryJobs extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_corporation_industryjobs', function(Blueprint $table)
        {
            $table->increments('id');
            // Columns 
            $table->integer('jobID');
            $table->integer('jobCharacterID');
            $table->integer('installerID');
            $table->string('installerName');
            $table->integer('facilityID');
            $table->integer('solarSystemID');
            $table->string('solarSystemName');
            $table->integer('stationID');
            $table->integer('activityID');
            $table->integer('blueprintID');
            $table->integer('blueprintTypeID');
            $table->string('blueprintTypeName');
            $table->integer('blueprintLocationID');
            $table->integer('outputLocationID');
            $table->integer('runs');
            $table->decimal('cost');
            $table->integer('teamID');
            $table->integer('licensedRuns');
            $table->integer('probability');
            $table->integer('productTypeID');
            $table->string('productTypeName');
            $table->integer('status');
            $table->integer('timeInSeconds');
            $table->timestamp('startDate');
            $table->timestamp('endDate');
            $table->timestamp('pauseDate');
            $table->timestamp('completedDate');
            $table->integer('completedCharacterID');
            $table->integer('successfulRuns');
            // Data related timestamps
            $table->timestamps();
            $table->softDeletes();
            // Indexes
            $table->unique('jobID');
            $table->index('installerID');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eve_corporation_industryjobs');
    }

}
