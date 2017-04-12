<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReligionsTable extends Migration {

    public function up()
    {
        Schema::create('religions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('place_holder')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('religions');
    }
}