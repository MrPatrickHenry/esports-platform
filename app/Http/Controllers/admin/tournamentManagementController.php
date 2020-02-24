<?php

namespace App\Http\Controllers\admin;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tournament;
use App\Attendees;
use App\Tournament_Types;
use App\Arcade;
use App\Traits\apiResponse;
use App\Traits\todoCreation;
use App\User;
use Mail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\approvedToHost;
class tournamentManagementController extends Controller
{
  use apiResponse;
  use todoCreation;
  use Notifiable;


  /**
  * Display a listing of the resource.
  * @return \Illuminate\Http\Response
  */


  public function adminIndex(Request $request)
  {
    $adminTournamentsIndex = Tournament::all();
    return $this->responseAPI($adminTournamentsIndex);
  }


  public function showAttendees(Request $request)
  {
    $attendeeData = Attendees::where([['attendies.tournamentID','=', $request->tid]])->
    where('users.userType', '=', $request->attendeeType)
    ->join('users', 'users.id', '=', 'attendies.playerID')
    ->select('users.userType',
    'users.name',
    'users.email',
    'users.City',
    'users.Country',
    'users.gamerTag',
    'users.home_arcade',
    'users.Team',
    'attendies.status',
    'attendies.id as aid')->get();
    return $this->responseAPI($attendeeData);
  }

  public function index(Request $request)
  {

  	$now = Carbon::now();
  // need model to work correctly and better performance
  	$attendeeList = Attendees::where('playerID','=',$request->UID);
  	// $attendeeCount = $attendeeList->count();

  	$a = Attendees::where('playerID','=',$request->UID)->pluck ('tournamentID');
    // dd($a);

  	$count = count($a);
  	$AttendingData = DB::table('attendies')->where('id',$request->UID)->count();

  	if ($a->isEmpty()){

  		$results = Tournament::where([['launchStartDate','<=', $now],['endDate','>=',$now],['active','=','1']])
  		->join('files','files.id', '=', 'tournaments.bannerID')
      ->select('tournaments.*','files.path')->get();

  		$countRecords = count($results);
  		$tournamentsResponse = [
  			"status"=> "200",
  			"data"=>[
  				["results"=>$results,"recordCount"=>$countRecords,"attending"=>$AttendingData]
  			]
  			];
  //response should be in model for easier call back with messaging
  			return response()->json($tournamentsResponse,200);
  		}
  		else{
  		$b = Tournament::where([['launchStartDate','<=', $now],['endDate','>=',$now],['active','=','1']])
  		->join('files','files.id', '=', 'tournaments.pic1')
      ->select('tournaments.*','files.path')->whereNotIn('tournaments.id',[$a])->get();
  			$tournamentsResponseB = [
  				"status"=> "200",
  				"data"=>[
  					["results"=>$b,"attending"=>$AttendingData,"recordCount"=>$count]
  					]
  				];

  //response should be in model for easier call back with messaging
  				return response()->json($tournamentsResponseB,200);
  			}
  		}


  public function attending(Request $request)
  {
    if ($request->userType === "Arcade Owner") {
      $Attendinginsert = Attendees::create([
        'playerID' => $request->playerID,
        'teamsID' => $request->teamsID,
        'tournamentID'=> $request->tournamentID,
        'status' => "2"
      ]);
      return $this->responseAPI($Attendinginsert);
    } else {
      $AttendinginsertElse = Attendees::create([
        'playerID' => $request->playerID,
        'teamsID' => $request->teamsID,
        'tournamentID'=> $request->tournamentID,
        'status' => "1"
      ]);

      return $this->responseAPI($AttendinginsertElse);
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function createTournamentTypes(Request $request)
  {
    $createTournamentType = Tournament_Types::create(['type' => $request->type]);
    return $this->responseAPI($createTournamentType);
  }

  //read the above

  public function TournamentTypes()
  {
    $tournamentTypes = Tournament_Types::all();
    return $this->responseAPI($tournamentTypes);
  }


  public function createTournament(Request $request)
  {
    $shortag = str_replace(' ', '-', strtolower($request->n));
    $createTournament = Tournament::create(
      [
        'name' => $request->n,
        'sponsorName' => $request->sponsorName,
        'gameID' => $request->gtID,
        'sponsorUserID' => '2',
        'launchStartDate' => $request->lsd,
        'launchEndDate' => $request->led,
        'startDate' => $request->sd,
        'endDate' => $request->ed,
        'summary'=> $request->summary,
        'description' => $request->d,
        'mediaKit' => $request->mk,
        'rules' => $request->ru,
        'rewards' => $request->rq,
        'key'=>$request->key,
        'password'=>$request->password,
        'room'=>$request->room,
        'bannerID' => $request->b,
        'iconID' => $request->icond,
        'pic1' => $request->p,
        'video' => $request->v,
        'notes'  => $request->notes,
        'likes'=> '0',
        'active' => 1,
        'shortTag'=> $shortag,
        'key'=>$request->key,
        'summary'=>$request->summary,
        'password'=>$request->password,
        'room'=>$request->room,
        'eventType' => $request->et,
        'group'=>$request->group
      ]
    );
    return $this->responseAPI($createTournament);
  }

  public function likeEvent(Request $request)
  {
    $likeEvent = Tournament::find($request->tid)->increment('likes', 1);
    $HowManyLikes = Tournament::select('likes')->where('id', '=', $request->tid)->get();

    return $this->responseAPI($HowManyLikes);
  }

  public function dislikeEvent(Request $request)
  {
    $likeEvent = Tournament::find($request->tid)->decrement('likes', 1);
    $HowManyLikes = Tournament::select('likes')->where('id', '=', $request->tid)->get();
    return $this->responseAPI($HowManyLikes);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Request $request)
  {
    $UID = $request->uid;
    $now = Carbon::now()->toDateTimeString();
    $userTournaments = DB::table('tournaments')->where([
          ['launchStartDate','<=', $now],
          ['attendies.playerID','=',$UID],
          ['endDate','>=',$now],
          ['active','=','1']
          ])->join('attendies', 'attendies.tournamentID', '=', 'tournaments.id')
    ->join('files', 'files.id', '=', 'tournaments.pic1')
    ->select('tournaments.*', 'files.path')->get(); 
      $count = count($userTournaments);

      $payload = ["results"=>$userTournaments,
      "recordCount"=>$count];

      return $this->responseAPI($payload);
    }


    public function showTournamentData(Request $request)
    {
      $tournamentDataResult = Tournament::where('id', $request->tid)->get();
      return $this->responseAPI($tournamentDataResult);
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
      $input = $request->all();
      $tournament = Tournament::findorfail($request->id);
      $updateNow = $tournament->update($input);
      return $this->responseAPI('Success');
    }

    public function updateAtteneslist(Request $request)
    {
      $input = $request->all();
      //create some vars from data to move along in function
      $tournament = Attendees::find($request->id);
      $tournamentInfo = Attendees::find($request->id)->get();
      $uid = $tournamentInfo[0]->playerID;
      $tid = $tournamentInfo[0]->tournamentID;
      $tournamentName = $tournamentInfo[0]->name;
      $tournamentShortTag = $tournamentInfo[0]->shortTag;
      $arcdeOwnerEmail = Arcade::where('adminID', '=', $uid)->get();
      $email = $arcdeOwnerEmail[0]->email;
      // update the attendees table
      $updateNow = $tournament->update($input);

      // add todo items via DB api trait.
      if ($request->status === "1") {

        $this->createTasks($uid, $tid);
        // email the user
        // Notifications to be clarified by business
        $user = User::find($uid);
        $user->notify(new \App\Notifications\approvedToHost($tournamentShortTag));
        $this->sendTasks($email, $tournamentShortTag, $tournamentName);
      }
      return $this->responseAPI('Request Completed');
    }

    public function sendTasks($email, $tournamentShortTag, $tournamentName)
    {
      $activationToken = $tournamentShortTag;
      $to = $email;

      Mail::send(
        'emails.tournamentApproved',
        ['tournamentName' => $tournamentShortTag],
        function ($message) use ($to) {
          $message->from('Support@virtualities.co', 'Support VALVR');
          $message->to($to)->subject('You have been accepted');
        }
      );

      return $this->responseAPI('Request Completed');
    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(request $request)
    {
      $input = $request->all();
      $result=Tournament::where('id', $request->id)->destroy();
      return $this->responseAPI($result);
    }
  }
