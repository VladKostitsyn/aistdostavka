<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('foods', 'active')) {
            Schema::table('foods', function (Blueprint $table) {
                $table->boolean('active')->nullable()->default(1); // //added
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
        if (Schema::hasColumn('foods', 'active')) {
            Schema::table('foods', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
}
