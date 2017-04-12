<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostPhotosTable extends Migration {

    public function up()
    {
        Schema::create('post_photos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id');
            $table->integer('article_locale_id');
            $table->string('photo')->nullable()->default(null);
            $table->string('content')->nullable();
            $table->string('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('post_photos');
    }
}