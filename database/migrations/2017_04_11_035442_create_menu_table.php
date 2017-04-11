<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration {

    public function up()
    {
        Schema::create('menu', function(Blueprint $table) {
            $table->increments('id');
            $table->string('place_holder');
            $table->integer('parent_id')->nullable()->default(null);
            $table->string('icon');
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('menu');
    }
}