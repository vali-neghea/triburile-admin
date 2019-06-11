<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequirementsColumnsToTroopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('troop_levels');
        Schema::create('troop_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('troop_id')->unsigned();
            $table->foreign('troop_id')->references('id')->on('troops');
            $table->integer('level');
            $table->integer('clay_required');
            $table->integer('wood_required');
            $table->integer('metal_required');
            $table->integer('attack_power');
            $table->integer('defense_power');
            $table->integer('recruiting_duration');
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
