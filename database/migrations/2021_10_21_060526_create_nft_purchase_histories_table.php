<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNftPurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nft_purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->integer('product_id'); 
            $table->double('amount',12,2)->default(0.00);
            $table->string('order_id');
            $table->timestamp('purchase_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('sell_date')->nullable();
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
        Schema::dropIfExists('nft_purchase_histories');
    }
}
