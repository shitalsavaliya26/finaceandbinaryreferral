<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('sponsor_id')->default(0);
            $table->integer('placement_id')->default(0);
            $table->enum('child_position', ['left','right'])->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email');
            $table->string('password')->nullable();
            $table->longText('secure_password')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('signature')->nullable();
            $table->string('profile_image')->nullable()->default(0);
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('rank_id')->default(1);
            $table->integer('package_id')->default(0);
            $table->integer('invest_id')->nullable();
            $table->enum('status', ['active','inactive']);
            $table->unique(["email", "deleted_at"]);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
