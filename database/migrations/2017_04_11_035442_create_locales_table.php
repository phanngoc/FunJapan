<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalesTable extends Migration {

    public function up()
    {
        Schema::create('locales', function(Blueprint $table) {
            $table->increments('id');
            $table->string('iso_code', 2);
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('locales');
    }
}