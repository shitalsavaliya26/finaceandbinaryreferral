<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnStackingPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stacking_pools', function (Blueprint $table) {
            $table->string('description')->after('commission')->nullable();
            $table->tinyInteger('status')->after('description')->default(0)->comment('0 = pending , 1 = active , 2 = closed');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stacking_pools', function (Blueprint $table) {
            //
        });
    }
}
