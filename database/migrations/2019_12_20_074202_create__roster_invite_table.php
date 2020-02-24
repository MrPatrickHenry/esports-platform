<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRosterInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RosterInvite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('users_Email');
            $table->enum('status', ['Invited','Pending','Approved','Denied']);
                        $table->unsignedBigInteger('team_ID');
            $table->foreign('team_ID')->references('id')->on('teamProfile');
                        $table->unsignedBigInteger('player_ID');
            $table->foreign('player_ID')->references('id')->on('users');
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
        Schema::dropIfExists('RosterInvite');
    }
}
