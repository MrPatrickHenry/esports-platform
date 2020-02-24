<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster', function (Blueprint $table) {
            $table->bigIncrements('id');  
                $table->unsignedBigInteger('logo');

            $table->foreign('teamID')->references('id')->on('teams')->onUpdate('cascade')->nullable();
                            $table->unsignedBigInteger('playerID');

            $table->foreign('playerID')->references('id')->on('users')->onUpdate('cascade')->nullable();
            $table->string('position'); 
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
        Schema::dropIfExists('roster');
    }
}
