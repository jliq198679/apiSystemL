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
        Schema::create('content_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id','content_order_foreign_order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('offer_daily_id');
            $table->foreign('offer_daily_id','content_order_foreign_offer_daily_id')->references('id')->on('offers_daily');
            $table->unsignedInteger('counter_offer');
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
        Schema::dropIfExists('content_order');
    }
};
