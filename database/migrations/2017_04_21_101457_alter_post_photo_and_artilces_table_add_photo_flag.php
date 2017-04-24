<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostPhotoAndArtilcesTableAddPhotoFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_photos', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('post_photo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_photos', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('post_photo');
        });
    }
}
