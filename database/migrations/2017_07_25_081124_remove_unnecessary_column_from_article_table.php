<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnnecessaryColumnFromArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('auto_approve_photo');
            $table->dropColumn('photo_approval_bonus_point');
            $table->dropColumn('type');
        });

        Schema::table('article_locales', function (Blueprint $table) {
            $table->dropColumn('recommended');
            $table->dropColumn('is_top_article');
            $table->dropColumn('start_campaign');
            $table->dropColumn('end_campaign');
            $table->dropColumn('hide_always');
            $table->dropColumn('is_popular');
        });

        Schema::drop('surveys');
        Schema::drop('coupons');
        Schema::drop('coupon_users');
        Schema::drop('results');
        Schema::drop('questions');
        Schema::drop('answers');
        Schema::drop('popular_categories');
        Schema::drop('popular_series');
        Schema::drop('article_ranks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('category_id');
            $table->tinyInteger('auto_approve_photo');
            $table->tinyInteger('photo_approval_bonus_point');
            $table->tinyInteger('type');
        });

        Schema::table('article_locales', function (Blueprint $table) {
            $table->tinyInteger('recommended');
            $table->tinyInteger('is_top_article');
            $table->dateTime('start_campaign');
            $table->dateTime('end_campaign');
            $table->tinyInteger('hide_always');
            $table->tinyInteger('is_popular');
        });

        Schema::create('surveys', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('coupon_users', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('results', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('popular_categories', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('popular_series', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('article_ranks', function (Blueprint $table) {
            $table->timestamps();
        });
    }
}
