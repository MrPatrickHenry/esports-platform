<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodo extends Migration
{
/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
	Schema::create('todo', function (Blueprint $table) {
		$table->bigIncrements('id');

//userDataCapture
		$table->unsignedBigInteger('tournament_ID');
		$table->foreign('tournament_ID')->references('id')->on('tournaments');

		$table->unsignedBigInteger('user_ID');
		$table->foreign('user_ID')->references('id')->on('users');

		$table->unsignedBigInteger('arcade_ID');
		$table->foreign('arcade_ID')->references('id')->on('arcades');

		$table->unsignedBigInteger('title_ID');
		$table->foreign('title_ID')->references('id')->on('titles');

//Preperation
		$table->string('prepare_2_weeks_advance');
		$table->boolean('prepare_2_weeks_advance_COMPLETED');

		$table->string('Print_Setup_inStore_Marketing');
		$table->boolean('Print_Setup_inStore_Marketing_COMPLETED');

		$table->string('deposit_notificaiton');
		$table->boolean('deposit_notificaiton_COMPLETED');

		$table->string('invite_local_Gaming_community');
		$table->boolean('invite_local_Gaming_community_COMPLETED');

		$table->string('SocalMediaAwareness');
		$table->boolean('SocalMediaAwareness_COMPLETED');

//Runnign the Tournament
		$table->string('makeItaParty');
		$table->boolean('makeItaParty_COMPLETED');

		$table->string('Have_Extra_Staff');
		$table->boolean('Have_Extra_Staff_COMPLETED');

		$table->string('Side_Entertainment');
		$table->boolean('Side_Entertainment_COMPLETED');


		$table->string('Rules_engagement_Play');
		$table->boolean('Rules_engagement_Play_COMPLETED');


		$table->string('recordTopScoresBrackets');
		$table->boolean('recordTopScoresBrackets_COMPLETED');


		$table->string('DocumentEvent');
		$table->boolean('DocumentEvent_COMPLETED');

//Post Tournament Work
		$table->string('EmailCollection');
		$table->boolean('EmailCollection_COMPLETED');

		$table->string('InviteToJoinDiscordFacebook');
		$table->boolean('InviteToJoinDiscordFacebookCompleted');

		$table->string('GatherPhoneNumbers');
		$table->boolean('GatherPhoneNumbersCOMPLETED');

		$table->string('PostTournamentResultsandBuzz');
		$table->boolean('PostTournamentResultsandBuzzCOMPLETED');

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
	Schema::dropIfExists('todo');
}
}
