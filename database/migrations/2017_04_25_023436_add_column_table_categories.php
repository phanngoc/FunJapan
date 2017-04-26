<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('categories', function(Blueprint $table) {
            $table->string('name')->nullable(false);
            $table->string('short_name')->nullable(false);
            $table->string('locale_iso_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('categories', function(Blueprint $table){
            $table->dropColumn('name');
            $table->dropColumn('short_name');
            $table->dropColumn('locale_iso_code');                       
        });
    }
}
