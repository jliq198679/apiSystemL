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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name_offer');
            $table->text('description_offer');
            $table->string('url_imagen')->nullable(true);
            $table->unsignedBigInteger('group_offer_id')->nullable(true);
            $table->foreign('group_offer_id','foreign_group_offer_id')->references('id')->on('group_offers');
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
        Schema::dropIfExists('offers');
    }
};
