<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponTypeOfCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('coupons', 'coupon_type')){
            Schema::table('coupons', function (Blueprint $table) {
                $table->string('coupon_type')->nullable()->default(null)->after('discount_type');
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
        if (Schema::hasColumn('coupons', 'coupon_type')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('coupon_type');
            });
        }
    }
}
