<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_wallet_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('from_user_id')->default(0);
            $table->string('commission_type')->nullable();
            $table->double('amount',8,2);
            $table->text('description');
            $table->tinyInteger('type');
            $table->double('final_amount',8,2)->default(0.00);
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
        Schema::dropIfExists('commission_wallet_histories');
    }
}
