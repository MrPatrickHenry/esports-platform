<?php

use Illuminate\Http\Request;
use App\Scores;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
});

// Auth
Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
        Route::post('reset','AuthController@resetPassword');
        Route::post('password','AuthController@changePassword');

        Route::group(['middleware' => 'auth:api'], function() {
                Route::post('user/profile','user\profileController@show');
                Route::get('user', 'AuthController@user');
                Route::get('logout', 'AuthController@logout');
        });
});


Route::group(['prefix' => 'v1/admin',  'middleware' => 'auth:api'], function(){

                // user management
        Route::post('user/update','admin\userController@update');
        Route::post('user','admin\userController@show');
        Route::get ('users','admin\userController@index');

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
//Team Management
        Route::get ('teams', 'tournaments\teamProfile@index');


//Score management
        Route::get('scores','tournaments\ScoreController@index');
        Route::get('scoresReview', 'tournaments\ScoreController@reviews');
        Route::get('scoresDisputes','tournaments\ScoreController@disputes');
        Route::post('score','tournaments\ScoreController@edit');
});

//users
Route::group(['prefix' => 'v1/users',  'middleware' => 'auth:api'], function(){
        Route::get('listAll','user\profileController@index');
        Route::post('featureService','user\profileController@authProfile');
        Route::post('update/searchable','user\profileController@userEdit');
        Route::post('update','user\profileController@userEdit');
        Route::post('update/avatar','user\profileController@userEdit');
        Route::post('update/social','user\profileController@userEdit');
        Route::post('media/item','user\profileController@showMedia');
        Route::post('profile','user\profileController@show');
        Route::post('arcades','user\profileController@showUserArcade');
        Route::post('profile/media','user\profileController@showMedia');
        Route::post('profile/delete/media','user\profileController@deleteMedia');
        Route::post('tournaments', 'admin\tournamentManagementController@index');
        Route::post('tournaments/attending', 'admin\tournamentManagementController@attending');
        Route::post('delete','user\profileController@delete');
        Route::delete('delete/GDPR','user\profileController@destroy');
        Route::post('settings/update','user\SettingsController@update');
        Route::post('settings','SettingsController@show');
//arcades
        Route::post('update/arcade','admin\arcadeLocaterController@edit');
//files
        Route::post('upload','admin\userController@store');
        Route::post('files','coreControllers  \filesController@store');
        Route::get('files/{id}','filesController@show');
});

Route::group(['prefix' => 'v1/arcades',  'middleware' => 'auth:api'], function(){
        Route::post('update/arcade','admin\arcadeLocaterController@edit');
        Route::post('arcade/update/setLogo', 'user\profileController@setBusinessLogo');

});
// tournaments
Route::group(['prefix' => 'v1/tournaments',  'middleware' => 'auth:api'], function(){
        Route::post('competitors','tournaments\tournamentController@attendiesList');
        Route::post('host', 'tournaments\tournamentController@host');

        Route::post('attending', 'admin\tournamentManagementController@show');
        Route::post('attend','admin\tournamentManagementController@attending');
        Route::post('like','admin\tournamentManagementController@likeEvent');
        Route::post('dislike','admin\tournamentManagementController@disLikeEvent');
        Route::post('score', 'tournaments\ScoreController@create');
        Route::post('dispute/{id}','tournaments\ScoreController@dispute');
});


// Public API access
Route::group(['prefix'=>'v2'], function () {
        Route::get('health_check', 'admin\serverStatusController@index');
        Route::get('show/{gamerTag}','user\profileController@gamerTagShow');
        Route::get('show/Arcade/{arcadeName}','arcade\arcadeLocaterController@arcadeShow');
        Route::post('authorizeToken','AuthController@authorizeToken');
        Route::post('activation/creation/arcade', 'admin\arcadeLocaterController@arcadeUserCreation');
        Route::get('leaderboard','leaderboradController@index');
        Route::get('scores', 'tournaments\ScoreController@index');
        Route::get ('arcade','arcade\arcadeLocaterController@index');
        Route::post('users/activation/creation','user\profileController@userActivationsubmission');
        Route::post('lboard','tournaments\tournamentController@leaderboard');
        Route::post('fservice', 'FeatureService@index');
        Route::get('contentlocker','contentLocker\videoContent@index');
        Route::post('title/show','developers\titlesController@titleshow');
        Route::get('titles','developers\titlesController@index');

        Route::get('developer/show/{shortTag}', 'developers\developerController@profileShow');
        Route::get('notification','user\profileController@notify');
        Route::post('tournament/like','admin\tournamentManagementController@likeEvent');
        Route::post('search/{searchTerm}','coreControllers\searchController@searchBasic');
        Route::post('send/message/marketing','admin\messages@store');

        Route::post('host/map','tournaments\tournamentController@hostMapData');

        // tournaments
               Route::get('tournament/list', 'tournaments\tournamentController@list');
        Route::post('tournament/show', 'tournaments\tournamentController@show');

});

Route::group(['prefix'=>'v2/tracking'], function(){
        Route::get('ad','admin\trackingController@index');
        Route::post('ad','admin\trackingController@store');

});
