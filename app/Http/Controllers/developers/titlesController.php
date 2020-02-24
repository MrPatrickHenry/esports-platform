<?php

namespace App\Http\Controllers\developers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Title;
use App\Traits\apiResponse;
use App\Tournament;
class titlesController extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titlesList = Title::all();
        return $this->responseAPI($titlesList);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Titles = new Title;
        $Titles->developer=$request->developer;
        $Titles->name=$request->name;
        $Titles->desc=$request->desc;
        $Titles->availability=$request->availability;
        $Titles->rules=$request->rules;
        $Titles->links=$request->links;
        $Titles->pic=$request->pic;
        $Titles->video=$request->video;
        $Titles->icon=$request->icon;
        $Titles->active= "1";
        $Titles->player_Count=$request->player_Count;
        $Titles->game_Type=$request->game_Type;
        $Titles->save();

        return $this->responseAPI('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titlesList = Title::findorfail($id);
        return $this->responseAPI($titlesList);
    }


    public function titleshow(Request $request){


      $title = Title::where('shortTag', '=', $request->shortTag)
       ->Join('developers', 'titles.developer', '=', 'developers.id')
       ->Join('files', 'titles.pic', '=', 'files.id')
      ->select(
      'titles.name',
      'titles.id',
      'titles.links',
      'titles.player_Count',
      'titles.game_Type',
      'titles.updated_at',
      'developers.name as devName',
      // 'files.*'
      'files.path as bannerArt'
      )->get();


      $tournaments = Tournament::where('gameID','=',$title[0]->id)->get();

$payload = ['title' => $title,
            ['tournaments' => $tournaments]];

      return $this->responseAPI($payload);





    }

    public function update(Request $request)
    {
        $input = $request->all();
        $score = Title::findorfail($request->id);
        $updateNow = $score->update($input);
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
        $team = Title::find($id);
        $team->delete();

        return $this->responseAPI('success');
    }
}
