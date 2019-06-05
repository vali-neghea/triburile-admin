<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAndCreateNewVillageBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village_building',function (Blueprint $table){
            $table->increments('id');
            $table->integer('village_id')->unsigned();
            $table->foreign('village_id')->references('id')->on('villages');
            $table->integer('building_id')->unsigned();
            $table->foreign('building_id')->references('id')->on('buildings');
            $table->integer('level');
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
        //
    }
}
