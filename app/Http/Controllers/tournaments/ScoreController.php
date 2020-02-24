<?php

namespace App\Http\Controllers\tournaments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scores;
use Carbon\Carbon;
use App\Files;
use Illuminate\Support\Arr;
use App\Traits\apiResponse;

class ScoreController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $scoresList = Scores::all();
        return $this->responseAPI($scoresList);
    }

    public function reviews()
    {
        $scoresList = Scores::where('confirmed', 0)->orderBy('created_at', 'desc')->get();
        return $this->responseAPI($scoresList);
    }


    public function disputes()
    {
        $scoresList = Scores::where('dispute', 1)->orderBy('updated_at', 'desc')->get();
        return $this->responseAPI($scoresList);
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request)
    {

//get files from request their will be only three direct inputs due to the matches been had.
        $match1 = $request->file('match0')->store('media/scores');
        $match2 = $request->file('match1')->store('media/scores');
        $match3 = $request->file('match2')->store('media/scores');
        $match4 = $request->file('match3')->store('media/scores');
        $match5 = $request->file('match4')->store('media/scores');

        //build collection array to loop through saving them
        $collection = collect([$match1,$match2,$match3,$match4,$match5]);
        // store return paths in to new array
        $mediapaths = array();
        //loop through collections saving details in to files table pushing to the paths array
        foreach ($collection as $matchScore) {
            $scoresSaved = Files::create([
            'user_id' => $request->userID,
            'file_name' => $request->title,
            'type' => 'png',
            'category_id'=>3,
            'path' => $matchScore,
            'is_public'=>0
        ]);
            array_push($mediapaths, $scoresSaved);
        }

        //Save the score with new media path to the model
        $scores = new Scores;
        $scores->tournament=$request->tID;
        $scores->round=$request->round;
        $scores->homeArcade=$request->homeArcade;
        $scores->homePlayer=$request->homePlayer;
        $scores->opponenet=$request->opponenet;
        $scores->match1=$mediapaths[0]['id'];
        $scores->match2=$mediapaths[1]['id'];
        $scores->match3=$mediapaths[2]['id'];
        $scores->match1Score=$request->match1Score;
        $scores->match2Score=$request->match2Score;
        $scores->match3Score=$request->match3Score;
        $scores->comments=$request->commments;
        $scores->winner=$request->winner;
        $scores->referee=$request->ref;
        $scores->confirmed=0;
        $scores->dispute=0;
        $scores->submitedBy=$request->submitedBy;
        $scores->save();
        return $this->responseAPI('Success');
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
        $score = Scores::where('id', $request->id)->get();
        return $this->responseAPI($score);
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {
        $input = $request->all();
        $score = Scores::findorfail($request->id);
        $updateNow = $score->update($input);
        return $this->responseAPI('Success');
    }

    public function dispute(Request $request, $id)
    {
        $scoreUpdate = Scores::updateOrCreate(['id' => $id], ['dispute' => 1]);
        return $this->responseAPI($scoreUpdate);
    }
}
