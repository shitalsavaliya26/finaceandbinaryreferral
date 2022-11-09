<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldColumnsToUserReferralsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_referrals', function (Blueprint $table) {
            //
            $table->longText('upline_ids')->nullable()->change();
            $table->longText('direct_downline_ids')->nullable()->change();
            $table->longText('downline_ids')->nullable()->change();
            $table->longText('placement_ids')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_referrals', function (Blueprint $table) {
            //
            $table->longText('upline_ids')->change();
            $table->longText('direct_downline_ids')->change();
            $table->longText('downline_ids')->change();
            $table->longText('placement_ids')->change();
        });
    }
}
