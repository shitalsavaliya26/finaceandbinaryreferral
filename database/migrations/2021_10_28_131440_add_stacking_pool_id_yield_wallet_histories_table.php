<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStackingPoolIdYieldWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yield_wallet_histories', function (Blueprint $table) {
            $table->integer('stacking_pool_id')->default(0); 
            $table->string('unique_no')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yield_wallet_histories', function (Blueprint $table) {
            //
        });
    }
}
