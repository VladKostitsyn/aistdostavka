<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinimumSumOfDeliveryFreeToRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasColumn('restaurants', 'minimum_sum_of_delivery_free')){
            Schema::table('restaurants', function (Blueprint $table) {
                $table->double('minimum_sum_of_delivery_free', 8, 2)->nullable()->default(null)->after('admin_commission');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('restaurants', 'minimum_sum_of_delivery_free')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->dropColumn('minimum_sum_of_delivery_free');
            });
        }
    }
}
