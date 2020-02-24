<?php

namespace App\Http\Controllers\admin;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\filesController;
use App\User;
use App\Files;
use App\Traits\apiResponse;

class userController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $userList = User::all();
        return $this->responseAPI($userList);
    }

    public function showMedia(Request $request)
    {
        $filterThese = ['id' => $request->user_ID, 'is_public' => 1, 'deleted_at' => null];
        $usersMedia = Files::select('id', 'path', 'updated_at', 'created_at')
        ->where('user_id', '=', $request->user_ID)
        ->orderBy('created_at', 'desc')->get();
        return $this->responseAPI($usersMedia);
    }


    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
        $data = User::find($request->uid);
        return $this->responseAPI($data);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function userEdit(Request $request)
    {
        $input = $request->all();
        $user = User::findorfail($request->uid);
        $updateNow = $user->update($input);
        return $this->responseAPI('success');
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
        $user = User::findorfail($request->uid);
        $updateNow = $user->update($input);
        return $this->responseAPI('success');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * GDPR COMPLIANCE
    */
    public function destroy(Request $request, $id)
    {
        $input = $request->all();
        $result=User::where('id', $request->id)->destroy();
        return $this->responseAPI($result);
    }


    // Delete the user softly

    public function delete(Request $request, $id)
    {
        $input = $request->all();
        $user = User::findorfail($request->id);
        $updateNow = $user->update($input);
        $softDelete = $user->delete();
        return $this->responseAPI('success');
    }
}
