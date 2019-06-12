<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageRecruitmentTable extends Migration
{
    /**w
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village_recruitment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('village_id')->unsigned();
            $table->foreign('village_id')->references('id')->on('villages');
            $table->integer('troop_id')->unsigned();
            $table->foreign('troop_id')->references('id')->on('troops');
            $table->integer('number_of_troops');
            $table->integer('time_per_troop');
            $table->dateTime('finish_date');
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
        Schema::dropIfExists('village_recruitment');
    }
}
