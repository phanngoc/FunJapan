<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialAccountsTable extends Migration {

    public function up()
    {
        Schema::create('social_accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('provider_user_id', 50);
            $table->string('provider');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('social_accounts');
    }
}