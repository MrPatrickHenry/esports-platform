<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {

Route::post('update/arcade','admin\arcadeLocaterController@edit');
// Route::get('arcade/{shortTag}' 'arcade\arcadeLocaterController@profile');
Route::post('mapdata','arcade\arcadeLocaterController@mapArray');
Route::post('todoCreate','arcade\todoController@storeRecordNewTournament');
Route::post('todo/user/create','arcade\todoController@createTask');
Route::post('todoList','arcade\todoController@list');
Route::post('todoShow','arcade\todoController@show');
Route::post('todo/iscompleted','arcade\todoController@updateChecklist');
Route::post('tournament/todo/list','arcade\todoController@getArcadeTodoList');
});
