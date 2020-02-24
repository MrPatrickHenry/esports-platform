<?php

namespace App\Http\Controllers\arcade;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Arcade;
use App\Tournament;
use App\Team;
use App\Tracking;
use App\Scores;
use App\Files;
use App\Traits\apiResponse;
use App\Attendes;
class analytics extends Controller
{
  public function Leaguesummary(Request $request)
  {

$arcadeID = $request->aid;
$userID = $request->uid;
      // more pasta?
      //user List
      $userList = User::where('home_arcade', '=', $arcadeID )->get();
      $userCount = $userList->count();
      //Arcade List
    //Developer and Title list

      //Tournament
      $tournamentList = Attendes::where([['playerID','=',$userID],[`status`,'=','1']])->get();
      $tournamentCount = $tournamentList->count();
      //Team
      $teamList = Team::where('home_arcade', '=', $arcadeID )->get();
      $teamCount = $teamList->count();
      //Tracking
            // Top Players
      $topPlayers = DB::table('Scores')
  ->select(['users.gamertag', DB::raw('MAX(Scores.Match1Score) AS High_Score')])
  ->Join('users', 'Scores.homePlayer', '=', 'users.id')
  ->where([['Scores.id', '>', '1'],['home_arcade', '=', $arcadeID]])
  ->groupBy(
      'users.gamertag',
      'Scores.tournament'
  )->orderBy('High_Score', 'desc')
  ->limit(10)->get();


      //Hot Player
      $topPlayergamerTag = $topPlayers[0]->gamertag;

      $topPlayer = User::where('gamertag', $topPlayergamerTag)->select('id', 'gamertag', 'home_arcade', 'facebook', 'discord', 'youtube', 'twitter', 'profilePic')->limit(1)->get();

      // Gender BreakDown
      $genderData = User::whereNotNull('users.activated_at')
->select(['users.gender',DB::raw('COUNT(users.gender) AS total')])->groupBy('users.gender')->orderBy('total', 'desc')->get();


      //country breakdown
      $cityData = User::whereNotNull('users.activated_at')->('home_arcade', '=', $arcadeID)
->select(['users.city',DB::raw('COUNT(users.city) AS total')])->groupBy('users.city')->orderBy('total', 'desc')->get();


      $topPlayerProfilePic = Files::where('id','=', $topPlayer[0]->profilePic)->select('path')->get();

      $topPlayer = data_set($topPlayer, '0.profilePic', $topPlayerProfilePic[0]->path);

      //response and structure
      $payload = [
          "results"=>
          ["Users"=>$userCount,
                      "Team"=>$teamCount,
                      "GenderBreakDown"=>$genderData,
                      "countryBreakDown"=>$countryData,
                      "Tournaments"=>$tournamentCount,
                      "TopPlayers"=>$topPlayers],
                      "HotPlayer"=>
                          $topPlayer

];
      return $this->responseAPI($payload);
  }
}
