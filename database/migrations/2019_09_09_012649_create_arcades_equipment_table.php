<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArcadesEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arcade_eq', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('arcadeID');
        $table->foreign('arcadeID')->references('id')->on('arcades')->onDelete('cascade')->onUpdates('cascade');
        $table->unsignedBigInteger('eqID');
        $table->foreign('eqID')->references('id')->on('equipment')->onUpdates('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('arcade_eq');
    }
}
