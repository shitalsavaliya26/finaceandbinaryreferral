<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnDatatypeInStackingPoolPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stacking_pool_packages', function (Blueprint $table) {
            //
            $table->float('stacking_display_start',12,2)->default(0.00)->change();
            $table->float('stacking_display_end',12,2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stacking_pool_packages', function (Blueprint $table) {
            //
            $table->integer('stacking_display_start')->default(0)->change();
            $table->integer('stacking_display_end')->default(0)->change();
        });
    }
}
