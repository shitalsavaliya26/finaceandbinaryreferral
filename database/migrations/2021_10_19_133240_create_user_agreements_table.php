<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_agreements', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->default(0);
            $table->string('aml_policy_statement')->nullable()->default(1);
            $table->string('risk_disclosure_statement')->nullable()->default(1);
            $table->string('user_agreement')->nullable()->default(1);
            $table->string('poa')->nullable()->default(1);
            $table->string('user_signature')->nullable()->default(1);
            $table->date('date_of_registration')->nullable();
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
        Schema::dropIfExists('user_agreements');
    }
}
