<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('old_rank_id')->nullable();
            $table->string('old_rank')->nullable();
            $table->string('new_rank')->nullable();
            $table->integer('new_rank_id');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('rank_histories');
    }
}
