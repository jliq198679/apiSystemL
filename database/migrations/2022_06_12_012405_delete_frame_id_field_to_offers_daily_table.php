<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFrameIdFieldToOffersDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers_daily', function (Blueprint $table) {
            $table->dropForeign('foreign_frame_web_id');
            $table->dropColumn('frame_web_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers_daily', function (Blueprint $table) {
            $table->unsignedBigInteger('frame_web_id');
            $table->foreign('frame_web_id','foreign_frame_web_id')->references('id')->on('frames_web');
        });
    }
}
