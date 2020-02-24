<?php

namespace App\Http\Controllers\admin;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Arcade;
use App\Traits\apiResponse;

class arcadeLocaterController extends Controller
{
    use apiResponse;

    public function arcadeShow($arcadeName)
    {
        $arcadeID = $arcadeName;

        $arcade = Arcade::where('arcadeName', $arcadeID)->get();
        $ArcadeFiles = Files::select('id')->where('id', $arcade[0]->logo)->get();
        $arcadeLogoPath = Files::where('id', '=', $ArcadeFiles[0]->id)->value('path');
        $appendedArcadeData = data_set($arcade, '0.logo', $arcadeLogoPath);

        $payload = [
            "result"=>$appendedData,
            "media"=>$usersMedia,
            "arcade"=>$appendedArcadeData,
            "team"=>$teamData
        ];

        return $this->responseAPI($payload);
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
        $score = Arcade::findorfail($request->id);
        $updateNow = $score->update($input);
        return $this->responseAPI('success');
    }
    public function arcadeUserCreation(Request $request)
    {
        //move to model after sept... so nasty
        if (!$request->has('uid')) {
            //no parameter
            return $this->responseAPI('No Parameter found');
        }

        $now = Carbon::now()->toDateTimeString();
        $name =$request->Arcadename;
        $email=$request->Arcadeemail;
        $phone =$request->Arcadephone;
        $desc=$request->desc;
        $Address1=$request->ArcadeAddress1;
        $Address2=$request->ArcadeAddress2;
        $city=$request->Arcadecity;
        $state=$request->Arcadecity;
        $country=$request->Arcadecountry;
        $Zip_Post=$request->ArcadezipPost;
        $shortag = str_replace(' ', '-', strtolower($request->Arcadename));
        // lat and long

        $client = new \GuzzleHttp\Client();
        $addressToken = "?address=";
        $keyToken = "&key=AIzaSyAgZTNmcFlNIA1DXWImgbDhUjDTLGtxvLE ";
        //Dirty
        $addForURI = '+';
        $address = $Address1.$addForURI.$Address2.$addForURI.$city.$addForURI.$state.$addForURI.$country.$addForURI.$Zip_Post;
        $baseURI = "https://maps.googleapis.com/maps/api/geocode/json";
        $url = $baseURI . $addressToken . $address. $keyToken;
        $requestUserData = $client->get($url);
        $UserResponse = $requestUserData->getBody()->getContents();
        $userResponseArray = json_decode($UserResponse);
        $lat = data_get($userResponseArray, 'results.0.geometry.location.lat');
        $long = data_get($userResponseArray, 'results.0.geometry.location.lng');


        $hours=$request->hours;
        $logo = $request->logolink;
        $notes = $request->notes;
        $active = $request->active;
        $website = $request->website;
        $YouTube=$request->youtube;
        $twitch=$request->twitch;
        $Snapchat=$request->snapchat;
        $Twitter=$request->twitter;
        $Telegram=$request->telegram;
        $Discord=$request->discord;
        $facebook=$request->facebook;
        $Liceenses=$request->licensing;
        $arcadeUpdateResponse = DB::table('arcades')->where('adminID', $request->uid)->insert(
            [
                // 'profile_pic' => $profile_pic,
                'adminID'=>$request->uid,
                'arcadeName' => $name,
                'email' => $email,
                'phone' => $phone,
                'description' => $desc,
                'address1' => $Address1,
                'address2' => $Address2,
                'city'=>$city,
                'state'=>$state,
                'country'=>$country,
                'zip_postal' => $Zip_Post,
                'youtubeChannel' => $YouTube,
                'Snapchat' => $Snapchat,
                'Twitter' => $Twitter,
                'Telegram' => $Telegram,
                'Discord' => $Discord,
                'twitch'=>$twitch,
                'logo'=>128,
                'lat'=>$lat,
                'lng'=>$long,
                'website' => $website,
                'hours'=> $hours,
                'verified'=>0,
                'licensing'=>$Liceenses,
                'active'=>1,
                'short-Tag'=>$shortag,
                'created_at'=>$now,
                'updated_at' => $now
            ]
        );

        return $this->responseAPI($arcadeUpdateResponse);
    }
}
