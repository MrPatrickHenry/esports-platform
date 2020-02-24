<?php

namespace App\Http\Controllers\user;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UploadAssetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\User;
use App\Files;
use App\Arcade;
use App\Team;
use App\Feature;
use App\Scores;
use App\Notification;
use Illuminate\Support\Facades\Hash;

use App\Traits\apiResponse;
use Illuminate\Notifications\Notifiable;

class profileController extends Controller
{
  use apiResponse;
  use Notifiable;

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */

  // TO implement as general

  public function authProfile(Request $request)
  {
    //Short profile for the navigation and Feature service
    $user = User::where('users.id', $request->id)
    ->select(
      'users.id',
      'users.uuid',
      'users.gamertag',
      'users.userType',
      'users.team',
      'users.profilePic',
      'users.country'
      )->groupBy('users.id', 'users.uuid', 'users.country', 'users.gamertag', 'users.team', 'users.profilePic', 'users.userType')->get();

      $filterThese = ['user_id' => $request->id, 'is_public' => 1, 'deleted_at' => null];
      $usersMedia = Files::select('id', 'path', 'updated_at', 'created_at')
      ->where($filterThese)->orderBy('created_at', 'desc')->get();
      $userProfileImage = DB::table('files')->where('id', '=', $user[0]->profilePic)->value('path');

      $user = data_set($user, '0.profilePic', $userProfileImage);

      //to get array of fields we need
      $input = User::where('users.id', $request->id)->select('name', 'email', 'password', 'phone', 'profilePic', 'gender', 'address1', 'address2', 'city', 'country', 'zip_postal', 'youtube', 'snapchat', 'facebook', 'twitter', 'telegram', 'instagram', 'discord', 'dob', 'userType', 'gamertag', 'home_arcade', 'team', 'favourite_VR_Title', 'state', 'twitch')->get()->toArray();

      //totals of the array
      $total = count($input[0]);
      // filter nulls
      $filledin = array_filter($input[0]);
      $filledinCount = count($filledin);

      //notifications
      $notificationsUnRead = Notification::where('notifiable_id','=',$request->id)->whereNull('read_at')->get();
      $notificationUnReadCount = count($notificationsUnRead);

      // Features Available
      $listings = Feature::where('user_Type', $user[0]->userType)->get();
      $userAuthProfileResponse =
      ["result"=>$user,
      "notifications"=>$notificationUnReadCount,
      "navigation"=>$listings,
      "accountInfo"=>round($filledinCount / $total *100)];
      return $this->responseAPI($userAuthProfileResponse);
    }

    public function showUserArcade(Request $request)
    {
      $arcade = Arcade::where('adminID', $request->uid)->get();
      return $this->responseAPI($arcade);
    }

    public function notify(){
      $user = User::find(1);

      $details = [
        'greeting' => 'Hi Artisan',
        'body' => 'This is our example notification tutorial',
        'thanks' => 'Thank you for visiting codechief.org!',
      ];

      $user->notify(new \App\Notifications\approvedToHost($details));
      return 'done';

    }


    public function showMedia(Request $request)
    {
      $filterThese = ['id' => $request->mid, 'is_public' => 1, 'deleted_at' => null];
      $usersMedia = Files::select('id', 'path', 'updated_at', 'created_at')->where('id', '=', $request->mid)->orderBy('created_at', 'desc')->get();
      return $this->responseAPI($usersMedia);
    }

    //show profile account
    public function show(Request $request)
    {
      //take request to a user VAR

      $userID = $request->id;

      //get user data for player and update the array response, should this a be a join for perfoamnce....YES! TODO

      $user = User::where('id', $userID)->get();

      $filterThese = ['user_id' => $userID, 'is_public' => 1, 'deleted_at' => null];

      $usersMedia = Files::select('id', 'path', 'updated_at', 'created_at')
      ->where($filterThese)->orderBy('created_at', 'desc')->get();

      $userProfileImage = DB::table('files')->where('id', '=', $user[0]->profilePic)->value('path');

      $user = data_set($user, '0.profilePic', $userProfileImage);

      $teamData = Team::where('users.id', $userID)
      ->join('users', 'teamProfile.team_Manager', '=', 'users.id')
      ->select(
        'teamProfile.team_Name',
        'teamProfile.id',
        'teamProfile.website',
        'teamProfile.twitter',
        'teamProfile.twitch',
        'teamProfile.discord',
        'teamProfile.instagram',
        'teamProfile.recruting',
        'users.name AS team_Manager'
        )->get();
        $payloadUser = ["result"=>$user,"media"=>$usersMedia,"team"=>$teamData];

        //IF they are arcade owner append the arcade info so logo is in..
        if ($user[0]->userType === 'Arcade Owner') {
          $arcade = Arcade::where('adminID', $userID)->get();

          $ArcadeFiles = Files::select('id')->where('id', $arcade[0]->logo)->get();
          $arcadeLogoPath = Files::where('id', '=', $ArcadeFiles[0]->id)->value('path');
          $appendedArcadeData = data_set($arcade, '0.logo', $arcadeLogoPath);


          $payload=["result"=>$user,"media"=>$usersMedia,"arcade"=>$appendedArcadeData,"team"=>$teamData];

          return $this->responseAPI($payload);
        } else {
          return $this->responseAPI($payloadUser);
        }
      }

      public function gamerTagShow($gamerTag)
      {

        //take request to a user VAR
        $userID = $gamerTag;

        $userisPublic = User::where('gamertag',$userID)->select('public')->get();


        if($userisPublic[0]->public != 1){
          return $this->responseAPI('private');

        }

        $user = User::where('gamertag', $userID)->select(
          'name',
          'gamertag',
          'profilePic',
          'coverboard',
          'youtube',
          'snapchat',
          'facebook',
          'twitter',
          'telegram',
          'instagram',
          'discord',
          'home_arcade',
          'favourite_VR_Title',
          'twitch',
          'state',
          'country',
          'created_at',
          'updated_at'
          )->get();

          $userIDs = User::where('gamertag', $userID)->select('id')->get();
          $filterThese = ['user_id' => $userIDs[0]->id, 'is_public' => 1, 'deleted_at' => null];

          $usersMedia = Files::select('id', 'path', 'updated_at', 'created_at')
          ->where($filterThese)->orderBy('created_at', 'desc')->get();

          $userProfileImage = DB::table('files')->where('id', '=', $user[0]->profilePic)->value('path');
          $usercoverboardImage = DB::table('files')->where('id', '=', $user[0]->coverboard)->value('path');

          $user = data_set($user, '0.profilePic', $userProfileImage);
          $user = data_set($user, '0.coverboard',$usercoverboardImage);

          $scoresList = Scores::where('Scores.homePlayer', $userIDs[0]->id)
          ->orWhere('Scores.opponenet', $userIDs[0]->id)
          ->where('Scores.confirmed', 1)
          ->join('tournaments', 'tournaments.id', '=', 'Scores.tournament')
          ->join('arcades', 'arcades.id', '=', 'Scores.homeArcade')
          ->select('tournaments.name as gameTitle', 'arcades.arcadeName', 'Scores.Match1Score as score', 'Scores.created_at as submitted')->orderBy('Scores.created_at')->get();

          $teamData = Team::where('users.id', $userIDs[0]->id)
          ->join('users', 'teamProfile.team_Manager', '=', 'users.id')
          ->select(
            'teamProfile.team_Name',
            'teamProfile.id',
            'teamProfile.website',
            'teamProfile.twitter',
            'teamProfile.twitch',
            'teamProfile.discord',
            'teamProfile.instagram',
            'teamProfile.recruting',
            'users.name AS team_Manager'
            )->get();

            $payloadUser = ["result"=>$user,"scores"=>$scoresList,"media"=>$usersMedia,"team"=>$teamData];

            //IF they are arcade owner append the arcade info so logo is in..
            if ($user[0]->userType === 'Arcade Owner') {
              $arcade = Arcade::where('adminID', $userIDs[0]->id)->get();

              $ArcadeFiles = Files::select('id')->where('id', $arcade[0]->logo)->get();
              $arcadeLogoPath = Files::where('id', '=', $ArcadeFiles[0]->id)->value('path');
              $appendedArcadeData = data_set($arcade, '0.logo', $arcadeLogoPath);

              $payloadArcadeUser = ["result"=>$appendedData,"media"=>$usersMedia,"arcade"=>$appendedArcadeData,"team"=>$teamData];

              return $this->responseAPI($payloadArcadeUser);
            } else {
              return $this->responseAPI($payloadUser);
            }
          }

          public function setBusinessLogo(Request $request)
          {
            $input = $request->all();
            $arcadeUpdate = Arcade::findorfail('adminID', $request->UID);
            $updateNow = $arcadeUpdate->update($input);

            return $this->responseAPI($updateNow);
          }


          public function deleteMedia(Request $request)
          {

            // $result=Files::where('id',$request->id)->delete();
            $result=Files::destroy($request->id);
            return $this->responseAPI($result);
          }
          /**
          * Update the specified resource in storage.
          *
          * @param  \Illuminate\Http\Request  $request
          * @param  int  $id
          * @return \Illuminate\Http\Response
          */
          public function userEdit(Request $request)
          {
            $input = $request->all();

            $profileUpdate = User::findorfail($request->id);
            $updateNow = $profileUpdate->update($input);
            return $this->responseAPI($updateNow);
          }

          public function userActivationsubmission(Request $request)
          {
            // lat and long generation
            $client = new \GuzzleHttp\Client();
            $addressToken = "?address=";
            $keyToken = "&key=AIzaSyAgZTNmcFlNIA1DXWImgbDhUjDTLGtxvLE ";
            $addForURI = '+';
            $address = $request->address1.$addForURI.$request->address2.$addForURI.$request->city.$addForURI.$request->state.$addForURI.$request->country.$addForURI.$request->zipPost;
            $baseURI = "https://maps.googleapis.com/maps/api/geocode/json";
            $url = $baseURI . $addressToken . $address. $keyToken;
            $requestUserData = $client->get($url);
            $UserResponse = $requestUserData->getBody()->getContents();
            $userResponseArray = json_decode($UserResponse);
            $lat = data_get($userResponseArray, 'results.0.geometry.location.lat');
            $long = data_get($userResponseArray, 'results.0.geometry.location.lng');

            $public=$request->public;
            $FavouriteVR = $request->favourite_VR_Title;

            // Update record
            $updateDB = User::where('id', '=', $request->uid)->update(array(
              'phone' => $request->phone,
              'gender' => $request->gender,
              'address1' => $request->address1,
              'address2'=> $request->address2,
              'password' => Hash::make($request->password),
              'city'=>$request->city,
              'state'=>$request->state,
              'country'=>$request->country,
              'zip_postal' => $request->zipPost,
              'lat'=>$lat,
              'long'=>$long,
              'password' => bcrypt($request->password),
              'home_arcade' => $request->home_arcade,
              'headset'=>$request->headset,
              'favourite_VR_Title'=>$request->favourite_VR_Title,
              'team' => $request->team,
              'public'=>'1',
              'dob' => $request->dob,
            ));


            return $this->responseAPI($updateDB);
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
            return $this->responseAPI("success");
          }
        }
