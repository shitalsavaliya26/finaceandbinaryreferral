<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInUserAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_agreements', function (Blueprint $table) {
            //
            $table->renameColumn('aml_policy_statement','antimoney_laundering')->nullable()->default(1);
            $table->renameColumn('risk_disclosure_statement','coockie_policy')->nullable()->default(1);
            $table->renameColumn('user_agreement','privacy_policy')->nullable()->default(1);
            $table->renameColumn('poa','risk_disclosure')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_agreements', function (Blueprint $table) {
            //
            $table->renameColumn('antimoney_laundering','aml_policy_statement')->nullable()->default(1);
            $table->renameColumn('coockie_policy','risk_disclosure_statement')->nullable()->default(1);
            $table->renameColumn('privacy_policy','user_agreement')->nullable()->default(1);
            $table->renameColumn('risk_disclosure','poa')->nullable()->default(1);
        });
    }
}
