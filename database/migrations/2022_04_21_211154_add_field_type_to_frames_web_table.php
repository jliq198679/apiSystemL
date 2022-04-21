<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTypeToFramesWebTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frames_web', function (Blueprint $table) {
            $table->enum('type',['payload_frame','offer_daily','offer_promotion','another'])->default('payload_frame')->after('frame_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frames_web', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
