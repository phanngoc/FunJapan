<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->increments('id');
            // User information
            $table->integer('user_id')->nullable();
            $table->integer('user_ranking')->nullable();
            $table->boolean('new_user')->nullable();
            $table->boolean('registered_user')->nullable();
            $table->boolean('is_login')->default(0);
            $table->string('session_id');
            $table->string('os');
            $table->string('ua');
            $table->string('user_ip');
            $table->string('referral')->nullable();
            $table->integer('last_access');
            $table->integer('created_unix_time');
            $table->date('created_global_date');
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
        Schema::dropIfExists('activity_logs');
    }
}
