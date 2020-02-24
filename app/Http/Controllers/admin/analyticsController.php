<?php

namespace App\Http\Controllers\admin;

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

class analyticsController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function Leaguesummary()
    {
        // more pasta?
        //user List
        $userList = User::all();
        $userCount = $userList->count();
        //Arcade List
        $arcadeList = Arcade::all();
        $arcadeCount = $arcadeList->count();
        //Developer and Title list
        $allDevelopers = DB::table('developers')->count();
        $allTitles = DB::table('titles')->count();
        //Tournament
        $tournamentList = Tournament::all();
        $tournamentCount = $tournamentList->count();
        //Team
        $teamList = Team::all();
        $teamCount = $teamList->count();
        //Tracking
        $trackingClicks = Tracking::sum('click');
        $trackingImpressions = Tracking::sum('impression');
        // Top Players
        $topPlayers = DB::table('Scores')
    ->select(['users.gamertag', DB::raw('MAX(Scores.Match1Score) AS High_Score')])
    ->Join('users', 'Scores.homePlayer', '=', 'users.id')
    ->where('Scores.id', '>', '1')
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
        $countryData = User::whereNotNull('users.activated_at')
->select(['users.country',DB::raw('COUNT(users.country) AS total')])->groupBy('users.country')->orderBy('total', 'desc')->get();


        $topPlayerProfilePic = Files::where('id','=', $topPlayer[0]->profilePic)->select('path')->get();

        $topPlayer = data_set($topPlayer, '0.profilePic', $topPlayerProfilePic[0]->path);

        //response and structure
        $payload = [
            "results"=>
            ["Users"=>$userCount,
            "Team"=>$teamCount,
            "Arcades"=>$arcadeCount,
                        "GenderBreakDown"=>$genderData,
                        "countryBreakDown"=>$countryData,
                "Developers"=>$allDevelopers,
                        "Tournaments"=>$tournamentCount,
                           "Titles"=>$allTitles,
                        "TopPlayers"=>$topPlayers],
                        "HotPlayer"=>
                            $topPlayer,
                        "tracking"=>[
                            "Total_Clicks"=>$trackingClicks,
                            "Total_Impressions"=>$trackingImpressions,
                            "CTR"=>round($trackingClicks/$trackingImpressions*100)
                        ]

];
        return $this->responseAPI($payload);
    }
}
