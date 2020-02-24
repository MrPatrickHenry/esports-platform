<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {
	Route::get('titles','developers\titlesController@index');

        Route::post('titles/store','developers\titlesController@store');
        Route::post('titles/update','developers\titlesController@update');

});
