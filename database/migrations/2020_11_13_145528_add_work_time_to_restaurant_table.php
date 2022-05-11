<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkTimeToRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'work_time_start')) {
                $table->time('work_time_start')->default('00:00:00');
            }
            if (!Schema::hasColumn('restaurants', 'work_time_end')) {
                $table->time('work_time_end')->default('00:00:00');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('restaurants', 'work_time_start') && Schema::hasColumn('restaurants', 'work_time_end')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->dropColumn(['work_time_start', 'work_time_end']);
            });
        }
    }
}
