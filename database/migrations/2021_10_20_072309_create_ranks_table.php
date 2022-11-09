<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->double('investment',12,2)->default(0.00);
            $table->integer('addtional_benifit')->default(0);
            $table->integer('no_of_sponsors')->default(0);
            $table->double('personal_monthly_sale',12,2)->default(0.00);
            $table->double('personal_monthly_group_sale',12,2)->default(0.00);
            $table->integer('rank_level')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('ranks');
    }
}
