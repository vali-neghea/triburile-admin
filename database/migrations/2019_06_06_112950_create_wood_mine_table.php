<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoodMineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wood_mine', function (Blueprint $table) {
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
        Schema::dropIfExists('wood_mine');
    }
}
