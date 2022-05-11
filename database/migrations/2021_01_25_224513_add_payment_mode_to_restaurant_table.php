<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentModeToRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('restaurants', 'payment_mode')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->tinyInteger('payment_mode')->default(0);
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
        if (Schema::hasColumn('restaurants', 'payment_mode')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->dropColumn(['payment_mode']);
            });
        }
    }
}
