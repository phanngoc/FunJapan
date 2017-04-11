<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

    public function up()
    {
        Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('photo');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('articles');
    }
}