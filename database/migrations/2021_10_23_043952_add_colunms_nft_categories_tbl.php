<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunmsNftCategoriesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nft_categories', function (Blueprint $table) {
            $table->enum('is_deleted', ['0', '1'])->default(0)->after('image');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nft_categories', function (Blueprint $table) {
            $table->dropColumn(['is_deleted', 'status']);
        });
    }
}
