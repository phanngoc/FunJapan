<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoulumnsToArticleLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_locales', function (Blueprint $table) {
            $table->integer('sub_category_id');
            $table->dateTime('end_published_at')->nullable()->default(null);
            $table->tinyInteger('content_type');
            $table->string('title_bg_color')->nullable()->default(null);
            $table->boolean('hide')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_locales', function (Blueprint $table) {
            $table->dropColumn('sub_category_id');
            $table->dropColumn('end_published_at');
            $table->dropColumn('content_type');
            $table->dropColumn('title_bg_color');
            $table->dropColumn('hide');
        });
    }
}
