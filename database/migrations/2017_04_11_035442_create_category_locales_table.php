<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryLocalesTable extends Migration {

    public function up()
    {
        Schema::create('category_locales', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('category_locales');
    }
}