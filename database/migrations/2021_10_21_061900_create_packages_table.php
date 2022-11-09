<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount',12,2)->default(0.00);
            $table->integer('stacking_actual12_start')->default(0);
            $table->integer('stacking_actual12_end')->default(0);
            // $table->integer('stacking_display24_start')->default(0);
            // $table->integer('stacking_display24_end')->default(0);
            $table->integer('stacking_actual24_start')->default(0);
            $table->integer('stacking_actual24_end')->default(0);
            $table->double('direct_refferal',12,2)->default(0.00);
            $table->double('network_pairing',12,2)->default(0.00);
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
        Schema::dropIfExists('packages');
    }
}
