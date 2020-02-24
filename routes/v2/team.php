<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {
        Route::get ('list', 'tournaments\teamProfile@index');
        Route::post('show', 'tournaments\teamProfile@show');
        Route::post('update','tournaments\teamProfile@update');
        Route::delete('delete/{id}','tournaments\teamProfile@destroy');
        Route::post('store','tournaments\teamProfile@store');
        Route::post('roster/list', 'tournaments\roster@show');
        Route::post('roster/update', 'tournaments\roster@updateRoster');
        Route::post('open/roster', 'tournaments\roster@rosterRecruitment');
        Route::post('join/team', 'tournaments\roster@update');
});