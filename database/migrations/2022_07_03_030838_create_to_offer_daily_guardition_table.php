<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToOfferDailyGuarditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_type_side_dish', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id','foreign_offer_id_pivot')->references('id')->on('offers');

            $table->unsignedBigInteger('type_side_dish_id');
            $table->foreign('type_side_dish_id','foreign_type_side_dish_id_pivot')->references('id')->on('type_side_dish');
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
        Schema::dropIfExists('offer_type_side_dish');
    }
}