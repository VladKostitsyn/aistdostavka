<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('orders', 'order_comment')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_comment')->nullable()->default('---')->after('readeble');

                //
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
        if (Schema::hasColumn('orders', 'order_comment')) {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_comment');
        });
    }
    }
}
