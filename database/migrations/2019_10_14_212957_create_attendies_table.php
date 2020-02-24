<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('playerID');
             $table->foreign('PlayerID')
            ->references('id')
            ->on('users');

            $table->unsignedBigInteger('teamsID');
            $table->foreign('teamsID')
            ->references('id')
            ->on('teams');

            $table->unsignedBigInteger('tournamentID');
            $table->foreign('tournamentID')
            ->references('id')
            ->on('tournaments');

            $table->boolean('attended')->nullable;

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
        Schema::dropIfExists('attendies');
    }
}
