<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCachedUntilTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cached_until', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ownerID')->unsigned();
            $table->string('api');
            $table->string('scope');
            $table->string('hash', 32);
            $table->dateTime('cached_until');
          // Indexes
            $table->index('ownerID');
            $table->index('api');
            $table->index('hash');
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
        Schema::dropIfExists('cached_until');
    }
}
