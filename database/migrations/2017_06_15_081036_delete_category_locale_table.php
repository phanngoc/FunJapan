<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteCategoryLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_locales', function (Blueprint $table) {
            $table->drop();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('category_locales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }
}
