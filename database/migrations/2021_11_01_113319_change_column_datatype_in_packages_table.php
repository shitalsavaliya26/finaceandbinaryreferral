<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnDatatypeInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->float('stacking_actual12_start',12,2)->default(0.00)->change();
            $table->float('stacking_actual12_end',12,2)->default(0.00)->change();
            $table->float('stacking_actual24_start',12,2)->default(0.00)->change();
            $table->float('stacking_actual24_end',12,2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('stacking_actual12_start')->default(0)->change();
            $table->integer('stacking_actual12_end')->default(0)->change();
            $table->integer('stacking_actual24_start')->default(0)->change();
            $table->integer('stacking_actual24_end')->default(0)->change();
        });
    }
}
