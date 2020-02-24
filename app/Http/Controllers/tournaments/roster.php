<?php

namespace App\Http\Controllers\tournaments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;
use App\User;
use App\RosterInvite;
use App\Traits\apiResponse;

class roster extends Controller

{
use apiResponse;

        public function rosterRecruitment(Request $request){
$OpenTeams = RosterInvite::where('player_ID', $request->id);

$openTeams = Team::where('teamProfile.recruting', '1')
->join('arcades', 'teamProfile.home_Arcade', '=', 'arcades.id')
->join('users', 'teamProfile.team_Manager', '=', 'users.id')
->select(
    'arcades.arcadeName',
'arcades.city',
'arcades.state',
'arcades.country',
'teamProfile.id',
'teamProfile.team_Name',
'teamProfile.website',
'teamProfile.twitter',
'teamProfile.twitch',
'teamProfile.discord',
'teamProfile.instagram',
'users.gamertag as team_Manager')->get();

        return $this->responseAPI($openTeams);


        }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(request $request)
	{

		$teamData = RosterInvite::where([
			['RosterInvite.status','=', $request->status],
			['RosterInvite.team_ID','=', $request->id]
		])
		->join('teamProfile', 'RosterInvite.team_ID', '=', 'teamProfile.id')
		->join('users', 'RosterInvite.player_ID', '=', 'users.id')
		->join('files', 'users.profilePic', '=', 'files.id')
		->select(
			'RosterInvite.status',
		       	'RosterInvite.id',
            'RosterInvite.updated_at', 
			'RosterInvite.users_Email',
			'users.gamertag',
			'users.name',
			'users.city',
			'users.country',
			'files.path AS profilePic')->get();

        return $this->responseAPI($teamData);

		}

		public function updateRoster(Request $request){

			$input = $request->all();
			$roster = RosterInvite::findorfail($request->id);
			$updateNow = $roster->update($input);

			if($roster->status === '0'){
				$User = User::where('id', '=', $roster->player_ID)->first();
				$User->team = null;
				$User->save();

                                return $this->responseAPI('success');


                                			}
			else{
				$User = User::where('id', '=', $roster->player_ID)->first();
				$User->team = $roster->team_ID;
				$User->save();
                                return $this->responseAPI('Success added to team');

			}

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

        $findPlayerData = User::findorfail($request->player_ID);
        $addtoTeam = RosterInvite::updateOrCreate([
        'users_Email'   => $findPlayerData->email,
        'status'     => '2',
        'team_ID' => $request->team_ID,
        'player_ID'    => $findPlayerData->id,
    ]);
return $this->responseAPI('Joined');


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

	}
}
