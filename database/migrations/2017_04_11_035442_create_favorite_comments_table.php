<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoriteCommentsTable extends Migration {

    public function up()
    {
        Schema::create('favorite_comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('comment_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('favorite_comments');
    }
}