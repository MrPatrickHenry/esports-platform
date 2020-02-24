<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {
        Route::post('competitors','tournaments\tournamentController@attendiesList');
        Route::post('attended','tournaments\tournamentController@previousAttended');
        Route::post('tournaments/list', 'admin\tournamentManagementController@index');
        Route::post('attending', 'admin\tournamentManagementController@show');
        Route::post('attend','admin\tournamentManagementController@attending');
        Route::post('dislike','admin\tournamentManagementController@disLikeEvent');
        Route::post('score', 'tournaments\ScoreController@create');
        Route::post('dispute/{id}','tournaments\ScoreController@dispute');
});
