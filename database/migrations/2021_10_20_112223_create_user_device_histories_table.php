<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDeviceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('login_token');
            $table->text('finger_uuid');
            $table->enum('device_type', ['android','ios']);
            $table->enum('finger_print', ['0','1'])->default('0');
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
        Schema::dropIfExists('user_device_histories');
    }
}
