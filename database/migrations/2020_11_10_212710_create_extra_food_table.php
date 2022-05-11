<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_food', function (Blueprint $table) {
            $table->integer('extra_id')->unsigned();
            $table->integer('food_id')->unsigned();
            $table->integer('extra_group_id')->unsigned();
            $table->primary([ 'food_id','extra_id']);
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_food');
    }
}
