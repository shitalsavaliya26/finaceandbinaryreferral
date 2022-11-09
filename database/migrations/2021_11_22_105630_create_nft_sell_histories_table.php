<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNftSellHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('nft_sell_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('nft_purchase_history_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->double('sale_amount', 8, 2)->default(0.00);
            $table->string('order_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->double('counter_offer_amount', 8, 2)->default(0.00);
            $table->text('remark')->nullable();
            $table->string('counter_offer_verification_key')->nullable();
            $table->tinyInteger('counter_offer_status')->default(0);
            $table->timestamp('approve_date')->nullable();
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
        Schema::dropIfExists('nft_sell_histories');
    }
}
