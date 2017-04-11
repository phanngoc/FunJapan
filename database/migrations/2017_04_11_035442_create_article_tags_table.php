<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTagsTable extends Migration {

    public function up()
    {
        Schema::create('article_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('article_locale_id');
            $table->string('article_id');
            $table->string('tag_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('article_tags');
    }
}