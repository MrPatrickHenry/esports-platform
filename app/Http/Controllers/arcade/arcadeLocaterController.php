<?php

namespace App\Http\Controllers\arcade;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Arcade;
use App\Files;
use App\User;
use App\Team;
use App\Attendees;
use App\Traits\apiResponse;

class arcadeLocaterController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $allArcades = Arcade::select('arcadeName', 'phone', 'email', 'city', 'country', 'website','short-Tag as shortTag')->orderByDesc('verified', 'tier')->get();
        return $this->responseAPI($allArcades);
    }


    public function mapArray(){

      return $allArcades = Arcade::select('arcadeName', 'lat','lng' ,'website')->orderByDesc('verified', 'tier')->get();
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $score = Arcade::findorfail($request->id);
        $updateNow = $score->update($input);
        return $this->responseAPI('success');
    }

    public function arcadeShow($arcadeName)
    {
        // too much pasta here needs a diet.
        $arcadeID = $arcadeName;

        $arcade = Arcade::where('arcadeName', $arcadeID)->select('id', 'arcadeName','city', 'country', 'website', 'phone', 'address1', 'address2', 'state', 'country', 'zip_postal', 'hours', 'youtubeVideo', 'snapchat', 'instagram', 'telegram', 'logo', 'twitter', 'twitch', 'header_Image', 'discord', 'description')->get();

        $ArcadeFiles = Files::select('id')->where('id', $arcade[0]->logo)->get();

        $arcadeLogoPath = Files::where('id', '=', $ArcadeFiles[0]->id)->value('path');

        $appendedArcadeData = data_set($arcade, '0.logo', $arcadeLogoPath);

        // $homeUsers = User::where('home_arcade',$arcade[0]->id,)->select([DB::raw('count(users.home_arcade) AS homeUsers')]);
        $teams = Team::where('home_arcade', $arcade[0]->id, )->select([DB::raw('count(teamProfile.home_arcade) AS teamTotals')])->get();

        $arcadeAdminID = Arcade::where('arcadeName', $arcadeID)->select('adminID')->get();

        $attendedTournaments = Attendees::where('playerID', $arcadeAdminID[0]->adminID, )->select([DB::raw('count(attendies.playerID) AS attenededTotal')])->get();

        // $likesTotal = Arcades::where('id',$ArcadeFiles[0]->id,)->select([DB::raw('count(arcades.likes) AS likesTotal')]);

        // create array
        $stats = array(
      "teams" =>$teams[0]->teamTotals ,
      "tournaments" => $attendedTournaments[0]->attenededTotal
    );
        $payload = ["result"=>$appendedArcadeData,"stats"=>$stats];
        return $this->responseAPI($payload);
    }
}
