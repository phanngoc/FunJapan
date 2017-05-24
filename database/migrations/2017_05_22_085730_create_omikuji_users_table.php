<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmikujiUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omikuji_users', function(Blueprint $table) {
             $table->increments('id');
             $table->dateTime('omikuji_play_time');
             $table->integer('user_id');
             $table->integer('omikuji_id');
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('omikuji_users');
    }
}
