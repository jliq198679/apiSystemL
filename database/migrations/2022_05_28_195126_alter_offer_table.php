<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('name_offer');
            $table->string('name_offer_es')->after('id');
            $table->dropColumn('description_offer');
            $table->string('description_offer_es');

            $table->string('name_offer_en')->after('name_offer_es');
            $table->string('description_offer_en')->after('description_offer_es');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('name_offer');
            $table->string('description_offer');
            $table->dropColumn('name_offer_en');
            $table->dropColumn('description_offer_en');
        });
    }
}
