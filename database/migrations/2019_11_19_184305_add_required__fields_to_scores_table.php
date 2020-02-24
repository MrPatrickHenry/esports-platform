<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequiredFieldsToScoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scores', function (Blueprint $table) {
//score submission
			$table->unsignedBigInteger('tournament');
			$table->foreign('tournament')->references('id')->on('tournaments');
			$table->string('round',10);

			//TODO this will be linked later to bracket system
// $table->unsignedBigInteger('round');
//             $table->foreign('round')->references('id')->on('tournaments');

			$table->unsignedBigInteger('homeArcade');
			$table->foreign('homeArcade')->references('id')->on('arcades');
			$table->unsignedBigInteger('homePlayer');
			$table->foreign('homePlayer')->references('id')->on('users');
			
			$table->unsignedBigInteger('opponenet');
			$table->foreign('opponenet')->references('id')->on('users');
			$table->unsignedBigInteger('Match1');
			$table->foreign('Match1')->references('id')->on('files');
			$table->string('Match1Score',10)->nullable();
			$table->unsignedBigInteger('Match2');
			$table->foreign('Match2')->references('id')->on('files');
			$table->string('Match2Score',10)->nullable();
			$table->unsignedBigInteger('Match3');
			$table->foreign('Match3')->references('id')->on('files');
			$table->string('Match3Score',10)->nullable();
			$table->string('comments',500)->nullable();
			$table->unsignedBigInteger('winner');
			$table->foreign('winner')->references('id')->on('users');

//score submission validation from Admin
			$table->unsignedBigInteger('referee');
			$table->foreign('referee')->references('id')->on('users');
			$table->boolean('confirmed');
			$table->dateTimeTz('created_at');
			$table->dateTime('updated_at');
			$table->boolean('dispute');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('scores', function (Blueprint $table) {
			//
		});
	}
}
