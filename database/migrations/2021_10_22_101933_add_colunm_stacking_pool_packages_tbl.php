<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunmStackingPoolPackagesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stacking_pool_packages', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('image');
            $table->enum('is_deleted', ['0', '1'])->default(0)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stacking_pool_packages', function (Blueprint $table) {
            $table->dropColumn(['is_deleted', 'status']);
        });
    }
}
