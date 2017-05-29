<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJmbCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jmb_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ssz');
            $table->string('ssu');
            $table->integer('jmb_country_id');
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
        Schema::drop('jmb_cities');
    }
}
