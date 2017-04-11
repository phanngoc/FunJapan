<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleLocalesTable extends Migration {

    public function up()
    {
        Schema::create('article_locales', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('article_id');
            $table->string('title');
            $table->text('content');
            $table->integer('like_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->string('share_count');
            $table->integer('view_count')->default(0);
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('article_locales');
    }
}