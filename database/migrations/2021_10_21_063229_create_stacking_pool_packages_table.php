<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStackingPoolPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stacking_pool_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->text('description')->nullable();
            $table->integer('stacking_display_start')->default(0);
            $table->integer('stacking_display_end')->default(0);
            $table->string('image',255)->nullable();
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
        Schema::dropIfExists('stacking_pool_packages');
    }
}
