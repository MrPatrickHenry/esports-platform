<?php

namespace App\Http\Controllers\tournaments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;
use App\User;
use App\Files;
use App\Traits\apiResponse;

class teamProfile extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $teamList = Team::all();
        return $this->responseAPI($teamList);
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $team = new Team;
        $team->website = $request->website;
        $team->instagram = $request->instagram;
        $team->twitter = $request->twitter;
        $team->discord = $request->discord;
        $team->team_Name = $request->team_Name;
        $team->team_Manager = $request->team_Manager;
        $team->home_arcade = $request->home_Arcade;
        $team->team_Logo = $request->team_Logo;
        $team->recruting = $request->recruting;
        $team->save();

        $User = User::where('id', '=', $team->team_Manager)->first();
        $User->team = $team->id;
        $User->save();
        return $this->responseAPI('Success');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(request $request)
    {
        $userID = $request->id;

        $teamData = Team::where('files.user_id', $userID)
    ->join('files', 'teamProfile.team_Logo', '=', 'files.id')
    ->join('arcades', 'teamProfile.team_Manager', '=', 'arcades.adminID')
    ->join('users', 'arcades.adminID', '=', 'users.id')
    ->select(
        'teamProfile.team_Name',
        'teamProfile.id',
        'teamProfile.website',
        'teamProfile.twitter',
        'teamProfile.twitch',
        'teamProfile.discord',
        'teamProfile.instagram',
        'teamProfile.recruting',
        'files.path AS team_Logo',
        'arcades.arcadeName AS home_Arcade',
        'users.name AS team_Manager'
    )->get();
        return $this->responseAPI($teamData);
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        $input = $request->all();
        $team = Team::findorfail($request->id);
        $updateNow = $team->update($input);
        return $this->responseAPI('success');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();

        $User = User::where('id', '=', $team->team_Manager)->first();
        $User->team = null;
        $User->save();
        return $this->responseAPI('Terminated');
    }
}
