<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuLocalesTable extends Migration {

    public function up()
    {
        Schema::create('menu_locales', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('menu_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('menu_locales');
    }
}