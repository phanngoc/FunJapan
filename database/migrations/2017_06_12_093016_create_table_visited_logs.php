<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitedLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visited_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('relate_table_id');
            $table->integer('relate_table_type');
            $table->date('start_date');
            $table->integer('count')->default(1);
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
        Schema::table('visited_logs', function (Blueprint $table) {
            $table->drop();
        });
    }
}
