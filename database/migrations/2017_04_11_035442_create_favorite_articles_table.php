<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoriteArticlesTable extends Migration {

    public function up()
    {
        Schema::create('favorite_articles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('article_id');
            $table->string('article_locale_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('favorite_articles');
    }
}