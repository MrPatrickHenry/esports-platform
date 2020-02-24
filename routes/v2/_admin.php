<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {
        Route::get ('users','admin\userController@index');

// user management
        Route::post('user/update','admin\userController@update');
        Route::post('user','admin\userController@show');
        Route::get ('users','admin\userController@index');
        Route::post('showMedia','admin\userController@showMedia');
// arcade management
        Route::post('arcades/list','arcade\arcadeLocaterController@index');
        Route::get ('arcade','arcade\arcadeLocaterController@index');
        Route::post('arcade/item','admin\valAdminController@arcadeItem');
        Route::post('make/arcade','admin\valAdminController@createArcade');
        Route::post('arcade/update', 'admin\arcadeLocaterController@edit');
        Route::post('analytics','admin\analyticsController@Leaguesummary');
        Route::delete('arcade/{id}','admin\valAdminController@destroyArcade');
// tournaments
        Route::post('create/tournament/types', 'admin\tournamentManagementController@createTournamentTypes');
        Route::post('create/tournament','admin\tournamentManagementController@createTournament');
        Route::get ('tournament/types', 'admin\tournamentManagementController@TournamentTypes');
        Route::post('tournaments/list', 'admin\tournamentManagementController@adminIndex');
        Route::post('tournament/item','admin\tournamentManagementController@showTournamentData');
        Route::post('tournament/attending','admin\tournamentManagementController@showAttendees');
        Route::post('tournament/attend/host','admin\tournamentManagementController@updateAtteneslist');
        Route::post('update/tournament','admin\tournamentManagementController@update');
//Team Management
        Route::get ('teams', 'tournaments\teamProfile@index');


//Score management
        Route::get('scores','tournaments\ScoreController@index');
        Route::get('scoresReview', 'tournaments\ScoreController@reviews');
        Route::get('scoresDisputes','tournaments\ScoreController@disputes');
        Route::post('score','tournaments\ScoreController@edit');
// VIDEO Management
        Route::get('videos','admin\videoController@index');
// Feedback Management
        Route::get('feedback','admin\feedbackController@index');
        Route::post('feedback/store','admin\feedbackController@store');
        Route::post('feedback/show','admin\feedbackController@show');
});
