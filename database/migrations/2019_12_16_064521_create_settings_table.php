<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
	Schema::table('settings', function (Blueprint $table) {
		$table->unsignedBigInteger('team_Manager');
		$table->foreign('team_Manager')->references('id')->on('users');
		$table->boolean('share3rdParties')->default('0');
		$table->boolean('searchable')->default('0');
		$table->boolean('delete')->default('0');
		$table->string('team_Name',50);
		$table->unsignedBigInteger('home_Arcade');
		$table->foreign('home_Arcade')->references('id')->on('arcades');
	});
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down()
{
	Schema::dropIfExists('settings');
}
}
