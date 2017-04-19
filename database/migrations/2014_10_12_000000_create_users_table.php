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
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('rank')->default(1);
            $table->integer('point')->default(0);
            $table->integer('login_count')->default(0);
            $table->boolean('access_admin')->default(0);
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('invite_code')->nullable();
            $table->tinyInteger('subscription_new_letter')->nullable();
            $table->tinyInteger('subscription_reply_noti')->nullable();
            $table->string('remember_token')->nullable();
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
