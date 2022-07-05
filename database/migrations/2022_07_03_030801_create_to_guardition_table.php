<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToGuarditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_dish', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_side_dish_id');
            $table->foreign('type_side_dish_id','foreign_type_side_dish_id')->references('id')->on('type_side_dish');
            $table->string('name_side_dish_es');
            $table->string('name_side_dish_en');
            $table->unsignedFloat('price_cup','8',2)->default(0.00);
            $table->unsignedFloat('price_usd','8',2)->default(0.00);
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
        Schema::dropIfExists('side_dish');
    }
}
