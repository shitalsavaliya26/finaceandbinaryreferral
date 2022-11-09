<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStackingPoolsCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stacking_pools_coins', function (Blueprint $table) {
            $table->id();
            $table->integer('stacking_pool_package_id');
            $table->string('symbol')->nullable();
            $table->string('icon')->nullable();
            $table->double('price',12,2)->default(0.00);
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
        Schema::dropIfExists('stacking_pools_coins');
    }
}
