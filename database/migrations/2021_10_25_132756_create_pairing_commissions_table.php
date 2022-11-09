<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePairingCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairing_commissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('left_sale',12,2)->default(0.00);
            $table->double('right_sale',12,2)->default(0.00);
            $table->double('carry_forward',12,2)->default(0.00);
            $table->double('actual_amount',12,2)->default(0.00);
            $table->enum('commission_got_from',['left', 'right'])->nullable();
            $table->double('pairing_commission',12,2)->default(0.00);
            $table->double('pairing_percent',12,2)->default(0.00);
            $table->double('daily_limit',12,2)->default(0.00);
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
        Schema::dropIfExists('pairing_commissions');
    }
}
