<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSeITMetadata extends Migration
{

/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seit_metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
            // indexes
            $table->unique('key');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seit_metadata');
    }
}
