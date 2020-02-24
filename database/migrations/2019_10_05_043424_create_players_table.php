<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
                            $table->unsignedBigInteger('Players_ID');

            $table->foreign('Players_ID')
            ->references('id')
            ->on('users');
                                        $table->unsignedBigInteger('teams_ID');

            $table->foreign('teams_ID')
            ->references('id')
            ->on('teams');
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
        Schema::dropIfExists('players');
    }
}
