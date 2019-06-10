<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDurationColumnToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metal_mine',function (Blueprint $table) {
            $table->integer('upgrade_duration');
        });

        Schema::table('wood_mine',function (Blueprint $table) {
            $table->integer('upgrade_duration');
        });

        Schema::table('wall',function (Blueprint $table) {
            $table->integer('upgrade_duration');
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
