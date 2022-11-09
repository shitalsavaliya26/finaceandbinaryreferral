<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_commissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('from_user_id')->default(0);
            $table->integer('stacking_pool_id');
            $table->double('amount',8,2);
            $table->text('description');
            $table->tinyInteger('status');
            $table->double('actual_percent',5,2);
            $table->double('percent',5,2);

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
        Schema::dropIfExists('referral_commissions');
    }
}
