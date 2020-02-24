<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchups', function (Blueprint $table) {
            $table->bigIncrements('id');
                        $table->unsignedBigInteger('tournamentsID');

            $table->foreign('tournamentsID')
            ->references('id')
            ->on('tournaments');
            $table->unsignedBigInteger('tournaments_type_ID');

            $table->foreign('tournaments_type_ID')
            ->references('id')
            ->on('tournaments_types');
            $table->unsignedBigInteger('matchupID');
            $table->foreign('matchupID')
            ->references('id')
            ->on('matchups');
            $table->unsignedBigInteger('tournament_phase');
            $table->foreign('tournament_phase')
            ->references('id')
            ->on('tournaments_phases');
            $table->unsignedBigInteger('team_visitor');
            $table->foreign('team_visitor')
            ->references('id')
            ->on('teams');
            $table->unsignedBigInteger('team_local');
            $table->foreign('team_local')
            ->references('id')
            ->on('teams');
            $table->integer('score_local')->nullable();
            $table->integer('score_visitor')->nullable();
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
        Schema::dropIfExists('matchups');
    }
}
