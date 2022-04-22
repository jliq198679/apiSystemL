<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_promotion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('frame_web_id');
            $table->foreign('frame_web_id','offer_promotion_foreign_frame_web_id')->references('id')->on('frames_web');
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id','offer_promotion_foreign_offer_id')->references('id')->on('offers');

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
        Schema::dropIfExists('offer_promotion');
    }
}
