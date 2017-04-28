<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableArticlesAndPhotoAddColumnApprovePhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('post_photo', 'auto_approve_photo');
            $table->tinyInteger('type')->default(0);
        });

        Schema::table('article_locales', function (Blueprint $table) {
            $table->timestamp('start_campaign')->nullable()->default(null);
            $table->timestamp('end_campaign')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('auto_approve_photo', 'post_photo');
            $table->dropColumn('type');
        });

        Schema::table('article_locales', function (Blueprint $table) {
            $table->dropColumn('start_campaign');
            $table->dropColumn('end_campaign');
        });
    }
}
