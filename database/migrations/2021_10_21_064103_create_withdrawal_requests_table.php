<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->string('transaction_id')->nullable();
            $table->string('payment_address')->nullable();
            $table->string('payment_proof')->nullable();
            $table->text('remark')->nullable();
            $table->double('withdrawal_amount',12,2)->default(0.00);
            $table->double('payble_amount',12,2)->default(0.00);
            $table->enum('type', ['0','1','2','3','4'])->default('0')->comment('0 = Bank,1 =USDT , 2 = OMINI');
            $table->tinyInteger('status')->default(0)->comment('0 = Pending , 1 = Approve ,, 2 = reject , 3 = verifying');
            $table->string('usdt_verification_key')->nullable();
            $table->timestamp('action_date')->nullable();
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
        Schema::dropIfExists('withdrawal_requests');
    }
}
