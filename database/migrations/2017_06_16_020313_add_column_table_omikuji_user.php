<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableOmikujiUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omikuji_users', function (Blueprint $table) {
             $table->integer('recover_time');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omikuji_users', function (Blueprint $table){
            $table->dropColumn('recover_time');
        });
    }
}
