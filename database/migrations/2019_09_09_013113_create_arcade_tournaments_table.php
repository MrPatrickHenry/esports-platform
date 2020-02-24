<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArcadeTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arcade_tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('arcadeID');
            $table->foreign('arcadeID')->references('id')->on('arcades')->onDelete('cascade');
            $table->unsignedBigInteger('tournamentID');
            $table->foreign('tournamentID')->references('id')->on('tournaments')->onDelete('cascade');
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
        Schema::dropIfExists('arcade_tournaments');
    }
}
