<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

    public function up()
    {
        Schema::create('locations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('locale_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('locations');
    }
}