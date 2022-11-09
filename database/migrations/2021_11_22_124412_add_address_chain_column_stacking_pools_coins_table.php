<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressChainColumnStackingPoolsCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stacking_pools_coins', function (Blueprint $table) {
            $table->string('chain')->nullable();
            $table->string('address',255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stacking_pools_coins', function (Blueprint $table) {
            //
        });
    }
}
