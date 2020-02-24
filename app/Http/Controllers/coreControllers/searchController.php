<?php

namespace App\Http\Controllers\coreControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Arcade;
use App\Team;
use App\Tournament;
use App\ContentLocker;
use App\Traits\apiResponse;
use App\Title;
class searchController extends Controller
{
  use apiResponse;

public function searchBasic(Request $request,$searchTerm){

$searchTerm = $searchTerm;

$arcadeData = Arcade::where('short-Tag','like',"%{$searchTerm}%")->select('short-Tag','arcadeName')->get();

$playerData = User::where('gamerTag','like',"%{$searchTerm}%")->select('gamerTag','name')->get();

$tournamentData = Tournament::where('shortTag','like',"%{$searchTerm}%")->select('shortTag','name')->get();

$titleData = Title::where('shortTag','like',"%{$searchTerm}%")->select('name','desc')->get();

$contentData = ContentLocker::where('tags','like',"%{$searchTerm}%")->select('id','title','description','tags')->get();

$payload = ['arcades'=>$arcadeData,
            'playerData'=>$playerData,
            'titleData'=>$titleData,
            'tournamentData'=>$tournamentData,
            'contentData' =>$contentData];

            return $this->responseAPI($payload);

}

    //
}
