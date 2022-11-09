<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('crypto_wallet',12,2)->default(0.00);
            $table->double('yield_wallet',12,2)->default(0.00);
            $table->double('commission_wallet',12,2)->default(0.00);
            $table->double('nft_wallet',12,2)->default(0.00);
            $table->double('pairing_commission',12,2)->default(0.00);
            $table->double('referral_commission',12,2)->default(0.00);
            $table->double('withdrawal_balance',12,2)->default(0.00);
            $table->double('stacking_pool',12,2)->default(0.00);
            $table->double('carry_forward',12,2)->default(0.00);
            $table->double('carry_forward_to',['left','right'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallets');
    }
}
