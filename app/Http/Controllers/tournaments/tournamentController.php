<?php

namespace App\Http\Controllers\tournaments;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Tournament;
use App\User;
use App\Attendees;
use App\leaderboard;
use App\Traits\apiResponse;

class tournamentController extends Controller
{
    use apiResponse;

    public function showAttendees(Request $request)
    {
        $attendeeData = Attendees::where([['attendies.tournamentID','=', $request->tid],['users.userType','=', $request->userType]])
->join('users', 'users.id', '=', 'attendies.playerID')
->select('users.userType', 'users.name', 'users.email', 'users.City', 'users.Country', 'users.gamerTag', 'users.HomeArcade', 'users.Team')->get();
        return $this->responseAPI($attendeeData);
    }



    public function list(Request $request)
    {
      $now = Carbon::now();

      // need model to work correctly and better performance
      $attendeeList = Attendees::where('playerID', '=', $request->UID);
      $attendeeCount = $attendeeList->count();
      $a = Attendees::where('playerID', '=', $request->UID)->pluck('tournamentID');
      $count = count($a);
      $AttendingData = DB::table('attendies')->where('id', $request->UID)->count();

      if ($a->isEmpty()) {
        $results = Tournament::where([['launchStartDate','<=', $now],['endDate','>=',$now],['active','=','1']])
        ->join('files', 'files.id', '=', 'tournaments.pic1')
        ->select('tournaments.*', 'files.path')->get();

        $countRecords = count($results);
        $payload = ["results"=>$results,
        "attending"=>$AttendingData,
        "recordCount"=>$countRecords
      ];
      return $this->responseAPI($payload);
    } else {
    $b = Tournament::where([['launchStartDate','<=', $now],['endDate','>=',$now],['active','=','1']])
    ->Join('files', 'tournaments.pic1', '=', 'files.id')
    ->select(
    'tournaments.name',
    'tournaments.sponsorName',
    'tournaments.summary',
    'tournaments.startDate',
    'tournaments.endDate',
    'tournaments.bannerID',
    'tournaments.sponsorName',
    'tournaments.likes',
    'tournaments.id',
    'tournaments.group',
    'files.path',
    'tournaments.shortTag'
    )->get();

$count = count($b);
    $payloadB = [
    "results"=>$b,
    "recordCount"=>$count];
    return $this->responseAPI($payloadB);
}
    }

    public function previousAttended(Request $request){
      $now = Carbon::now();
// tournament link:asset
$tournamentIdData = Attendees::where('playerID', '=', $request->UID)->pluck('tournamentID');
$numberofTournaments = count($tournamentIdData);
//get all tournament data
$payload = Tournament::where([['launchStartDate', '<=', $now ],
['endDate','<=',$now],['active','=','0']])
->Join('files', 'tournaments.bannerID', '=', 'files.id')
->whereIn('tournaments.id',[$tournamentIdData])->select('tournaments.name',
      'tournaments.sponsorName',
      'tournaments.summary',
      'tournaments.startDate',
      'tournaments.endDate',
      'tournaments.bannerID',
      'tournaments.sponsorName',
      'tournaments.likes',
      'tournaments.id',
      'tournaments.group',
      'files.path',
      'tournaments.shortTag')->get();
      return $this->responseAPI(['tournaments'=>[$payload],'counts'=>[$numberofTournaments]]);
    }


public function show(Request $request)
    {

        $tournament = Tournament::where([['shortTag', '=', $request->shortTag],['active','=','1']])
    ->Join('files', 'tournaments.bannerID', '=', 'files.id')
    ->select(
        'tournaments.name',
        'tournaments.startDate',
        'tournaments.endDate',
        'tournaments.key',
        'tournaments.password',
        'tournaments.room',
        'tournaments.descriptionTournament',
        'tournaments.rules',
        'tournaments.rewards',
        'tournaments.bannerID',
        'tournaments.sponsorName',
        'tournaments.likes',
        'tournaments.id',
        'tournaments.group',
        'files.path as bannerArt'
    )->get();
$notActive = count($tournament);
if ($notActive == 0){
  return $this->responseAPI(['message' => 'Nothing Found','Active'=>$notActive]);
}
    $tid = $tournament[0]->id;
    $a = Attendees::where([['playerID', '=', $request->UID],['tournamentID','=',$tid]])->first();

 if($a){
   $attending = true;
 }
 else{
   $attending = false;
 }

 $tournament = data_set($tournament, '0.attending', $attending);
return $this->responseAPI($tournament);



    }

    public function host(Request $request)
    {
        $userID = User::find($request->id)->get();
        if ($userID[0]->userType === 'Arcade Owner') {
            $tournament = Tournament::where('shortTag', $request->shortTag)->select(
                    'key',
                    'password',
                    'room',
                    'mediaKit'
                )->get();
        } else {
            return false;
        }
        return $this->responseAPI($tournament);
    }

    public function attendiesList(Request $request)
    {
        $attendeeData = Attendees::where([['attendies.tournamentID','=', $request->tid],['users.userType','=', 'Player']])
        ->join('users', 'users.id', '=', 'attendies.playerID')
        ->select('users.gamerTag', 'users.Team','users.city','users.country')->get();
        return $this->responseAPI($attendeeData);
    }

public function hostMapData(Request $request){
  $attendeeMapData = Attendees::where([['attendies.tournamentID','=', $request->tid],['attendies.status','=', '1']])
  ->join('arcades', 'attendies.playerID', '=', 'arcades.adminID')
  ->select(
	'arcades.lat',
  'arcades.country',
  'arcades.city',
	'arcades.lng',
	'arcades.arcadeName as name',
	'arcades.short-Tag as shortTag'
  )->get();
  return $this->responseAPI($attendeeMapData);

}

    public function leaderboard(Request $request)
    {
        $leaderBoardTotal = DB::table('Scores')
            ->select(['users.id as user_ID',
                'users.gamertag',
                'users.country',
                'Scores.tournament', DB::raw('MAX(Scores.Match1Score) AS High_Score')])
            ->Join('users', 'Scores.homePlayer', '=', 'users.id')
            ->where('Scores.tournament', '=', $request->tournamentID)
            ->groupBy(
                'users.id',
                'users.gamertag',
                'users.country',
                'Scores.tournament'
            )->orderBy('High_Score', 'desc')
            ->get();
        return $this->responseAPI($leaderBoardTotal);
    }
}
