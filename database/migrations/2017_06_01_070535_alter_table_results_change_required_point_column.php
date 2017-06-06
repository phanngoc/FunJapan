<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableResultsChangeRequiredPointColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            if (Schema::hasColumn('results', 'required_point')) {
                $table->dropColumn('required_point');
            }

            $table->integer('required_point_from')->default(0);
            $table->integer('required_point_to')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            if (Schema::hasColumn('results', 'required_point_from')) {
                $table->dropColumn('required_point_from');
            }

            if (Schema::hasColumn('results', 'required_point_to')) {
                $table->dropColumn('required_point_to');
            }
        });
    }
}
