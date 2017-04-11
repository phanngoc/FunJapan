<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('description');
            $table->tinyInteger('rank')->default(1);
            $table->integer('point');
            $table->integer('login_count')->default(0);
            $table->boolean('access_admin')->default(0);
            $table->string('avatar');
            $table->boolean('gender');
            $table->date('birthday');
            $table->integer('religion_id');
            $table->integer('location_id');
            $table->integer('locale_id');
            $table->string('invite_code');
            $table->string('subscriptions', 45);
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
        Schema::dropIfExists('users');
    }
}
