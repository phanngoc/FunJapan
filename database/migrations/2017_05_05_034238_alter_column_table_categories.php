<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->string('icon')->nullable();
            $table->string('locale_id')->nullable();
            $table->dropColumn('locale_iso_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('photo');
            $table->dropColumn('icon');
            $table->dropColumn('locale_id');
            $table->string('locale_iso_code')->nullable();
        });
    }
}
