<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGroupOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_offers', function (Blueprint $table) {
            $table->dropColumn('name_group');
            $table->string('name_group_es')->after('id');
            $table->string('name_group_en')->after('name_group_es');
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
            $table->string('name_group');
            $table->dropColumn('name_group_en');
        });
    }
}
