<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoWalletsOnlinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_wallets_online_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->string('order_id');
            $table->string('transaction_id')->nullable();
            $table->text('response');
            $table->double('usd_amount',8,2)->default(0.00);
            $table->double('deposite_amount',8,2)->default(0.00);
            $table->date('payment_date');
            $table->string('time');
            $table->enum('status', ['0','1'])->default('0');
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
        Schema::dropIfExists('crypto_wallets_online_payments');
    }
}
