<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticlesAndArticleLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_locales', function(Blueprint $table) {
            $table->dropColumn('published_at');
            $table->tinyInteger('hide_alway')->default(0);
            $table->tinyInteger('is_member_only')->default(0);
        });

        Schema::table('article_locales', function(Blueprint $table) {
            $table->dateTime('published_at');
        });

        Schema::table('articles', function(Blueprint $table) {
            $table->integer('photo_approval_bonus_point')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_locales', function(Blueprint $table) {
            $table->dropColumn('published_at');
            $table->dropColumn('hide_alway');
            $table->dropColumn('is_member_only');
        });

        Schema::table('article_locales', function(Blueprint $table) {
            $table->timestamp('published_at');
        });

        Schema::table('articles', function(Blueprint $table) {
            $table->dropColumn('photo_approval_bonus_point');
        });
    }
}
