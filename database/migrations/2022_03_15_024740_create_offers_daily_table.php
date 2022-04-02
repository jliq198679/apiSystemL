<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_daily', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('frame_web_id');
            $table->foreign('frame_web_id','foreign_frame_web_id')->references('id')->on('frames_web');
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id','foreign_offer_id')->references('id')->on('offers');
            $table->unsignedFloat('price_cup','8',2)->nullable(true);
            $table->unsignedFloat('price_usd','8',2)->nullable(true);
            $table->integer('count_offer',false,true)->nullable(true);
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
        Schema::dropIfExists('offers_daily');
    }
};
