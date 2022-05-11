<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFoodIdFromExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extras', function (Blueprint $table) {
                $table->dropForeign('extras_food_id_foreign');
            if (Schema::hasColumn('extras', 'food_id')) {
                $table->dropColumn(['food_id']);
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
       /* Schema::table('extras', function (Blueprint $table) {
            $table->integer('food_id')->unsigned();
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade')->onUpdate('cascade');
        });*/
    }
}
