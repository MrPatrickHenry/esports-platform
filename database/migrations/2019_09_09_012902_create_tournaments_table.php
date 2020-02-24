<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',30);
            $table->unsignedBigInteger('gameID');
            $table->foreign('gameID')
            ->references('id')
            ->on('titles');
            $table->unsignedBigInteger('sponsorUserID');
            $table->foreign('sponsorUserID')
            ->references('id')
            ->on('users');  
            $table->string('sponsorName');
            $table->dateTimeTz('launchStartDate');
            $table->dateTimeTz('launchEndDate');
            $table->dateTimeTz('startDate');
            $table->dateTimeTz('endDate');
            $table->string('description',5000);
            $table->string('rules',5000);
            $table->string('rewards',100);
            $table->string('email',200);
            $table->unsignedBigInteger('iconID');
            $table->foreign('iconID')
            ->references('id')
            ->on('files');
            $table->unsignedBigInteger('bannerID');
            $table->foreign('bannerID')
            ->references('id')
            ->on('files');
            $table->unsignedBigInteger('pic1');
            $table->foreign('pic1')
            ->references('id')
            ->on('files');
            $table->unsignedBigInteger('pic2');
            $table->foreign('pic2')
            ->references('id')
            ->on('files');
            $table->unsignedBigInteger('video');
            $table->foreign('video')
            ->references('id')
            ->on('files');
            $table->string('twitter');
            $table->string('discord');
            $table->string('twitch');
            $table->string('youtube');
            $table->text('notes');
            $table->boolean('active');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
