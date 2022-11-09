<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNftWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nft_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->tinyInteger('type')->default(0)->comment('0 = usdt ,1 = malasian payment, 2 = coinpayment');
            $table->string('trans_slip')->nullable();
            $table->double('amount',8,2)->default(0.00);
            $table->double('usd_amount',8,2)->default(0.00);
            $table->tinyInteger('status')->default(0)->comment('0 = pending , 1 = Accept , 2 = Reject');
            $table->integer('unique_no')->nullable(); 
            $table->string('certificate_id')->nullable();
            $table->text('remark')->nullable();
            $table->text('payment_response')->nullable();
            $table->string('order_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('action_date')->nullable();
            $table->text('usdt_detail')->nullable();
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
        Schema::dropIfExists('nft_wallets');
    }
}
