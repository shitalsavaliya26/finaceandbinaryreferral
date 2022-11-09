<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualCommissionAmountColumnYieldWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yield_wallet_histories', function (Blueprint $table) {
            $table->double('actual_commission_amount')->default(0);
            $table->double('percent')->default(0);
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
