<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRequiredIsSingledToExtraGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extra_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('extra_groups', 'is_singled')) {
                $table->boolean('is_singled')->nullable()->default(0);
            }
            if (!Schema::hasColumn('extra_groups', 'is_required')) {
                $table->boolean('is_required')->nullable()->default(0);
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
        if (Schema::hasColumn('extra_groups', 'is_singled') && Schema::hasColumn('extra_groups', 'is_required'))
        {
            Schema::table('extra_groups', function (Blueprint $table) {
                $table->dropColumn(['is_singled', 'is_required']);
            });
        }
    }
}
