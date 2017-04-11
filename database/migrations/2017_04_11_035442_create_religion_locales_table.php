<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReligionLocalesTable extends Migration {

    public function up()
    {
        Schema::create('religion_locales', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('religion_id');
            $table->integer('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('religion_locales');
    }
}