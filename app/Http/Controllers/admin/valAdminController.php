<?php

namespace App\Http\Controllers\admin;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Aracade;
use App\User;
use App\Http\Controllers\AuthController;
use App\Traits\apiResponse;

class valAdminController extends Controller
{

use apiResponse;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createArcade(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $addressToken = "?address=";
        $keyToken = "&key=AIzaSyAgZTNmcFlNIA1DXWImgbDhUjDTLGtxvLE ";
        $addForURI = '+';
        $address = $request->Address1.$addForURI.$request->Address2.$addForURI.$request->City.$addForURI.$request->State.$addForURI.$request->Country.$addForURI.$request->Zip_Post;
        $baseURI = "https://maps.googleapis.com/maps/api/geocode/json";
        $url = $baseURI . $addressToken . $address. $keyToken;
        $requestUserData = $client->get($url);
        $UserResponse = $requestUserData->getBody()->getContents();
        $userResponseArray = json_decode($UserResponse);
        $lat = data_get($userResponseArray, 'results.0.geometry.location.lat');
        $long = data_get($userResponseArray, 'results.0.geometry.location.lng');
        
        $arcadeProfileStore = Arcade::create([
                'adminID' => '1',
                'arcadeName' => $request->$name,
                'email' => $request->$email, 
                'phone' => $request->$phone,
                'description' => $request->$desc,
                'website' => $request->$website,
                'Address1' => $request->$Address1,
                'Address2' => $request->$Address2,
                'City' => $request->$City,
                'lat' => $lat,
                'lng' =>$long,
                'state' => $request->$State,
                'Country' => $request->$Country,
                'Zip_postal' => $request->$Zip_Post,
                'YoutubeChannel' =>$request->$YouTube,
                'youtubeVideo' => $request->$Discord,
                'Snapchat' => $request->$Snapchat,
                'Instagram' => $request->$instagram,
                'Twitter' => $request->$Twitter,
                'twitch' => $request->$Twitch,
                'Telegram' => $request->$Telegram,
                'Discord' => $request->$Discord,
                'active' => '1',
                'notes' => 'TBA',
                'verified'=>'1',
            ]);
        return $this->responseAPI($arcadeProfileStore);
        }
    
    
//TODO move to service
public function uuid(){
    $random = Str::random(4);
    $friendlyUUID = strtolower($random);
    return $friendlyUUID;
}


public function createUser(Request $request){
    // lat and long generation should be a service TODO
        $client = new \GuzzleHttp\Client();
        $addressToken = "?address=";
        $keyToken = "&key=AIzaSyAgZTNmcFlNIA1DXWImgbDhUjDTLGtxvLE ";
        $addForURI = '+';
        $address = $request->Address1.$addForURI.$request->Address2.$addForURI.$request->city.$addForURI.$request->state.$addForURI.$request->country.$addForURI.$request->zipPost;
        $baseURI = "https://maps.googleapis.com/maps/api/geocode/json";
        $url = $baseURI . $addressToken . $address. $keyToken;
        $requestUserData = $client->get($url);
        $UserResponse = $requestUserData->getBody()->getContents();
        $userResponseArray = json_decode($UserResponse);
        $lat = data_get($userResponseArray, 'results.0.geometry.location.lat');
        $long = data_get($userResponseArray, 'results.0.geometry.location.lng');

        $public=$request->public;
        $FavouriteVR = $request->FavouriteVRTitle;
// Update record
        $updateDB = User::create([
                'name' => $request->$name,
                'userType' => $request->userType,
                'gamerTag'=> $request->gamerTag,
                'phone'=> $request->phone,
                'UUID' => $this.uuid(),
                'phone' => $request->$phone,
                'gender' => $request->$gender,
                'Address1' => $request->$Address1,
                'Address2'=> $request->$Address2,
                'City'=>$request->$city,
                'State'=>$request->$state,
                'Country'=>$request->$country,
                'Zip_Post' => $request->$Zip_Post,
                'lat'=>$lat,
                'long'=>$long,
                'HomeArcade' => $request->$HomeArcade,
                'FavouriteVRTitle'=>$request->$FavouriteVR,
                'gamerTag'=>$request->$gamerTag,
                'Team' => $request->$team,
                'public'=>$request->$public,
                'dob' => $request->$dob,
                'public'=>'0',
        ]);


                return $this->responseAPI($updateDB);


}

    public function editArcade(Request $request)
    {
        $input = $request->all();
        $score = Arcade::findorfail($request->id);
        $updateNow = $score->update($input);
                return $this->responseAPI('success');

    }


public function arcadeItem(Request $request)
    {
            $arcade = Arcade::where('id','=',$request->aid;)->get();
                return $this->responseAPI($arcade);

        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyArcade(Request $request, $id)
    {
        $input = $request->all();
        $arcade = Arcade::findorfail($request->id);
        $updateNow = $arcade->update($input);
        $softDelete = $arcade->delete();
                return $this->responseAPI('Success');

    }
}
