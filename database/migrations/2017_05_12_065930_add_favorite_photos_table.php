<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFavoritePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_photos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('post_photo_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::table('post_photos', function(Blueprint $table) {
            $table->integer('favorite_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('favorite_photos');

        Schema::table('post_photos', function(Blueprint $table) {
            $table->dropColumn('favorite_count');
        });
    }
}
