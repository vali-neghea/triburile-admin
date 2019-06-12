<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetalMineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metal_mine', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level');
            $table->integer('clay_required');
            $table->integer('wood_required');
            $table->integer('metal_required');
            $table->integer('bonus');
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
        Schema::dropIfExists('metal_mine');
    }
}