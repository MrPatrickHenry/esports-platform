<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use App\User;
use App\Traits\apiResponse;

class SettingsController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $settingsForUser = Settings::where([['user_ID','=', $request->id],['user.id','=',$request->id]])
    ->leftJoin('users', 'users.id', '=', 'settings.user_ID')
    ->select('users.name', 'users.gamertag', 'users.id', 'settings.share3rdParties', 'settings.searchable', 'settings.delete', 'settings.updated_at')->get();
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store(Request $request)
    {
        $settings = new Settings;
        $settings->user_ID = $request->id;
        $settings->save();
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Settings  $settings
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
        $arcade = Settings::where('user_ID', $request->id)->get();
        return $this->responseAPI($arcade);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Settings  $settings
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        $input = $request->all();
        $userSettingsUpdate = Settings::findorfail('user_ID', $request->id);
        $updateNow = $userSettingsUpdate->update($input);
        return $this->responseAPI($updateNow);
    }
}
