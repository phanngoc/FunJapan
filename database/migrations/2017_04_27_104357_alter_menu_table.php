<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->renameColumn('place_holder', 'description');
            $table->string('type');
            $table->string('name');
            $table->integer('order');
            $table->integer('locale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->renameColumn('description', 'place_holder');
            $table->dropColumn('type');
            $table->dropColumn('order');
            $table->dropColumn('name');
            $table->dropColumn('locale_id');
        });
    }
}
