<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('can_get_from');
            $table->dateTime('can_get_to');
            $table->dateTime('can_use_from');
            $table->dateTime('can_use_to');
            $table->integer('max_coupon')->nullable()->default(0);
            $table->integer('max_coupon_per_user')->nullable()->default(0);
            $table->integer('required_point')->nullable()->default(0);
            $table->string('image')->nullable();
            $table->string('pin')->nullable();
            $table->string('pin_code')->nullable();
            $table->softDeletes();
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
        Schema::drop('coupons');
    }
}
