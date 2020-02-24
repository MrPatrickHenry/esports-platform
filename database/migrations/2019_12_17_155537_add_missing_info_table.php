<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamProfile', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('team_Manager');
            $table->foreign('team_Manager')
            ->references('id')
            ->on('users');

            $table->string('team_Name',50);
            $table->string('website',50);
            $table->string('twitter',50);
            $table->string('twitch',50);
            $table->string('discord',50);
            $table->string('instagram',50);

            $table->unsignedBigInteger('team_Logo');
            $table->foreign('team_Logo')->references('id')->on('files');

            $table->unsignedBigInteger('home_Arcade');
            $table->foreign('home_Arcade')->references('id')->on('arcades');

            $table->boolean('recruting');
            $table->timestamps();
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
        Schema::table('teams', function (Blueprint $table) {
            //
        });
    }
}
