<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCategoryGroupOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_offers', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('name_group_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_offers', function (Blueprint $table) {
            $table->dropColumn('group_offers');
        });
    }
}
