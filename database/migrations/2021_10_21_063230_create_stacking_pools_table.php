<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStackingPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stacking_pools', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->integer('stacking_pool_package_id'); 
            $table->double('amount',12,2)->default(0.00);
            $table->double('percent',12,2)->default(0.00);
            $table->string('stacking_period');
            $table->string('range')->nullable();
            $table->string('commission')->default(0.00);
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
        Schema::dropIfExists('stacking_pools');
    }
}
