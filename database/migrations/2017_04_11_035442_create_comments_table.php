<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

    public function up()
    {
        Schema::create('comments', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->nullable()->default(null);
            $table->string('content');
            $table->integer('parent_id')->nullable()->default(null);
            $table->integer('article_id');
            $table->integer('article_locale_id');
            $table->integer('user_id');
            $table->integer('favorite_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
}