<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->group(function () {
//			Route::post('lboard','tournaments\tournamentController@user');
Route::post('featureService','user\profileController@authProfile');
Route::post('search','coreControllers\searchController@searchBasic');

//         Route::post('update/searchable','user\profileController@userEdit');
//         Route::post('authProfile','user\profileController@authProfile');
        Route::post('update','user\profileController@userEdit');
//         Route::post('update/avatar','user\profileController@userEdit');
        Route::post('update/social','user\profileController@userEdit');
        Route::post('media/item','user\profileController@showMedia');
        Route::post('profile','user\profileController@show');
        Route::post('arcades','user\profileController@showUserArcade');
//         Route::post('profile/media','user\profileController@showMedia');
        Route::post('profile/delete/media','user\profileController@deleteMedia');
        Route::post('tournaments', 'admin\tournamentManagementController@index');
//         Route::post('tournaments/attending', 'admin\tournamentManagementController@attending');
//         Route::post('delete','user\profileController@delete');
//         Route::delete('delete/GDPR','user\profileController@destroy');
        Route::post('settings/update','user\SettingsController@update');
        Route::post('settings','SettingsController@show');
        Route::post('notifications','coreControllers\notifications@index');
        Route::post('notifications/marked','coreControllers\notifications@read');
        Route::post('notifications/delete','coreControllers\notificaitons@delete');
// +//arcades
//                 // Route::post('update/arcade','admin\arcadeLocaterController@edit');
// //files
        Route::post('upload','admin\userController@store');
        Route::post('files','coreControllers\filesController@store');
        Route::get('files/{id}','filesController@show');
});
