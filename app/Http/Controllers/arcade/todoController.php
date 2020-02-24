<?php

namespace App\Http\Controllers\arcade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Todo;
use App\Tournament;
use App\Title;
use App\Checklist;
use App\Traits\apiResponse;
use Carbon\Carbon;

class todoController extends Controller
{
  use apiResponse;
  //
  public function storeRecordNewTournament(Request $request)
  {
    // on accepting/Accepted by VAL Admin show todo to them
    //also seperate the text in to another table to minimise the bloat!
    //     $createTODO = Todo::create(
    //         [
    //         'tournament_ID' => $request->tournament_ID,
    //         'user_ID' => $request->user_ID,
    //
    //     ]
    // );

    // return $this->responseAPI($createTODO);
  }
  // user created tasks
  public function createTask(Request $request){
    $taskCreation = Todo::create([
      'title' => $request->title,
      'user_ID' => $request->user_ID,
      'tournament_ID'=> $request->tournament_id,
      'category'=> $request->category,
      'status'=> 'todo',
      'description' => $request->desc
    ]);
    return $this->responseAPI($taskCreation);
  }
  //show users all TO DO Tasks
  public function list(Request $request)
  {
    $todoRequest = Todo::where('todo.user_ID', $request->user_ID)
    ->join('tournaments', 'todo.tournament_ID', '=', 'tournaments.id')
    ->join('titles', 'todo.title_ID', '=', 'titles.id')
    ->select('tournaments.id AS TournamentID', 'tournaments.name AS Tournament_Title', 'titles.name AS Game_Title', 'todo.id')->get();
    return $this->responseAPI($todoRequest);
  }

  function getTasks($uid,$tid,$categoryType,$completedRequest,$priorityRequest){

    $category = $categoryType;
    $completed = $completedRequest;
    $priority = $priorityRequest;
    $userID=$uid;
    $tournamentID=$tid;
    $todoRequestShowItem = Todo::where([['tasks.tournament_ID','=', $tournamentID],
    ['tasks.user_ID','=',$userID=$uid],
    ['tasks.category','like',$category],
    ['checkLists.is_completed','like',$completed],
    ['tasks.priority','like', $priority]])
    ->join('checkLists', 'tasks.id', '=', 'checkLists.task_id')
    ->join('tournaments', 'tasks.tournament_ID', '=', 'tournaments.id')
    ->select('tasks.title','tasks.description',
    'tasks.status',
    'tasks.priority',
    'tasks.category',
    'tasks.tournament_id',
    'tasks.id',
    // 'tournaments.name as tournament_Name',
    // 'tournaments.shortTag',
    'tournaments.startDate',
    'tasks.category',
    'tasks.priority',
    'checkLists.todo',
    'checkLists.is_completed',)->orderBy('tasks.priority','DESC')->get();
    return $todoRequestShowItem;
  }

  public function show(Request $request)
  {
    $tournamentData = Tournament::where('id',$request->tournament_ID)->select('tournaments.id AS TournamentID', 'tournaments.name AS Tournament_Title')->get();
    $payLoad = ['tournament' =>$tournamentData,
    'eventPreperation' => [$this->getTasks($request->userID,$request->tournament_ID,'Prep',$request->completed,$request->priority)],
    'socialGrowth'=> [$this->getTasks($request->userID,$request->tournament_ID,'Marketing',$request->completed,$request->priority)],
    'rulesRecord'=> [$this->getTasks($request->userID,$request->tournament_ID,'Recruitment',$request->completed,$request->priority)],
    'rulesRecord'=> [$this->getTasks($request->userID,$request->tournament_ID,'Document',$request->completed,$request->priority)],
    'postTournament'=> [$this->getTasks($request->userID,$request->tournament_ID,'Post',$request->completed,$request->priority)]];
    return $this->responseAPI($payLoad);
  }
  public function updateChecklist(Request $request)
  {
    $input = $request->all();
    $todo = Checklist::where('task_id',$request->id);
    $updateNow = $todo->update($input);
    return $this->responseAPI('success');
  }

  public function getArcadeTodoList(Request $request){
    $now = Carbon::now();

  $todoRequest = Tournament::where('attendies.playerID', $request->user_ID)
  ->where('attendies.status','1')
  ->where([['launchStartDate','<=', $now],['endDate','>=',$now],['active','=','1']])
  ->join('attendies', 'attendies.tournamentID', '=', 'tournaments.id')
  ->select('tournaments.id',
	'tournaments.name as tournamentName',
	'tournaments.startDate',
	'tournaments.endDate',
	'tournaments.shortTag')->get();
  return $this->responseAPI($todoRequest);
}
  public function update(Request $request)
  {
    $input = $request->all();
    $todo = Todo::findorfail($request->id);
    $updateNow = $todo->update($input);
    return $this->responseAPI('success');
  }
}
