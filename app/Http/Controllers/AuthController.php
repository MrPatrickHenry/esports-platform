<?php
namespace App\Http\Controllers;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Str;
use Mail;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Cookie\CookieJar;
use App\Traits\apiResponse;

class AuthController extends Controller
{
  use apiResponse;
  /**
  * Create user
  *
  * @param  [string] name
  * @param  [string] email
  * @param  [string] password
  * @param  [string] password_confirmation
  * @return [string] message
  */

  public function generateActivationToken(){
    $at = str_random(64);
    return $at;
  }

  public function send($email, $at)
  {
    $activationToken = $at;
    $to = $email;

    Mail::send('emails.authEmail',['activationToken' => $activationToken],
    function ($message) use ($to)
    {
      $message->from('Support@virtualities.co', 'Support VALVR');
      $message->to($to)->subject('Welcome To VAL');
    });

    return $this->responseAPI('Request Completed');

  }

  // should be under rules
  public function adminCheck($email, $ut){

    $adminDomain = "@virtualities.co";
    $userTypeCheck = $email;
    $ut = $ut;
    if(strstr($userTypeCheck,"@") == $adminDomain){
      $userType = 'VALAdmin';
      return $userType;
    }
    else{
      $userType = $ut;
      return $userType;
    }
  }
  public function uuid(){
    $random = Str::random(4);
    $friendlyUUID = strtolower($random);
    return $friendlyUUID;
  }


  public function signup(Request $request)
  {
    // account sign up validations
    $profile_picDefault = '196';
    $email =$request->email;
    $ut = $request->userType;
    $adminChecked = $this->adminCheck($email, $ut);
    $activationToken = $this->generateActivationToken();
    $uuid = $this->uuid();
    $request->validate([
      'name' => 'required|string',
      'userType' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'gamertag' => 'required|string|unique:users'
    ]);
    $user = new User([
      'name' => $request->name,
      'email' => $request->email,
      'gamertag' => $request->gamertag,
      'profilePic' => $profile_picDefault,
      'userType'=> $adminChecked,
      'authToken'=> $activationToken,
      'activated_at'=>null,
      'uuid' => $uuid,
    ]);
    $user->save();
    $this->send($email,$activationToken);
    return $this->responseAPI('Success Please check email for Confirmation');

  }

  public function invite(Request $request)
  {
    // account sign up validations
    $profile_picDefault = '181';
    $email =$request->email;
    $ut = $request->userType;
    $activationToken = $this->generateActivationToken();
    $uuid = $this->uuid();
    $request->validate([
      'name' => 'required|string',
      'userType' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'gamertag' => 'string'
    ]);
    $user = new User([
      'name' => $request->name,
      'email' => $request->email,
      'gamertag' => $request->gamerTag,
      'profilePic' => $profile_picDefault,
      'userType'=> $adminChecked,
      'authToken'=> $activationToken,
      'activated_at'=>null,
      'uuid' => $uuid,
    ]);
    $user->save();
    $this->send($email,$activationToken);
    return $this->responseAPI('Success Please check email for Confirmation');

  }

  public function changePassword (Request $request){
    $pd = $request->password;
    $pc = $request->password_confirmation;
    $email = $request->email;
    $now = Carbon::now()->toDateTimeString();

    // responses not good

    $notMatching = [
      "status"=> "201",
      "result"=> 'Passwords not matching'
    ];
    //end of responses

    if ($pd != $pc){
      return response()->json($notMatching,200);
    } else{

      $PasswordReset = DB::table('users')->where('email',$email)->update([
        'password' => bcrypt($request->password),
        'updated_at' => $now
      ]);

      return $this->responseAPI($PasswordReset);
    }
  }


  public function resetPassword(Request $request){
    $token = $request->token;
    $pd = $request->password;
    $pc = $request->password_confirmation;
    $email = $request->email;
    $now = Carbon::now()->toDateTimeString();

    // responses not good

    $notMatching = [
      "status"=> "201",
      "result"=> 'Passwords not matching'
    ];


    $tokenExpired = [
      "status"=> "201",
      "result"=> 'Token is Invalid'
    ];
    //end of responses
    if (!empty ($token)){
      try{
        if ($pd != $pc){
          return response()->json($notMatching,200);
        } else{

          $PasswordReset = DB::table('users')->where('email',$email)->update([
            'password' => bcrypt($request->password),
            'updated_at' => $now
          ]);

          return $this->responseAPI($PasswordReset);
        }
      }
      catch(Illuminate\Database\QueryException $qe){
        return json_encode($qe->getMessage());
      }
    }
    else{
      return response()->json($tokenExpired,200);

    }
  }


  public function authorizeToken(Request $request)
  {
    $token = $request->token;
    $Activate = DB::table('users')->select('id','userType')->where('authToken',$token)->whereNull('activated_at')->first();
    if (!empty ($Activate)){
      $payload = [$Activate,
      'message'=>'valid'];

      $this->ActivateAuthorisedAccount($token);
      return $this->responseAPI($payload);

    }else{
      $payload = ['message'=>'Invalid'];
      return $this->responseAPI($payload);
    }
  }

  public function ActivateAuthorisedAccount($token){
    $now = Carbon::now()->toDateTimeString();
    $token = $token;
    $activateUIpdate = DB::table('users')
    ->where('authToken',$token)
    ->update(['activated_at'=> $now]);
    return true;
  }

  /**
  * Login user and create token
  *
  * @param  [string] email
  * @param  [string] password
  * @param  [boolean] remember_me
  * @return [string] access_token
  * @return [string] token_type
  * @return [string] expires_at
  */
  public function login(Request $request)
  {
    //if not activated their email
    $userEmailToCheck = $request->email;
    $Activated = DB::table('users')->select('activated_at')->where('email',$userEmailToCheck)->whereNull('activated_at')->first();
    $checked = is_null($Activated);
    if (!$checked){
      $userNotification = [
        "status"=> "201",
        "message"=>'Email is not verified, please check your email.',
        'state'=>$checked
      ];

      return response()->json([$userNotification],201);

    }else{

      $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember_me' => 'boolean'
      ]);
      $credentials = request(['email', 'password',]);
      if(!Auth::attempt($credentials))
      return response()->json([
        'message' => 'Unauthorized'
      ], 401);
      $user = $request->user();
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      if ($request->remember_me)
      $token->expires_at = Carbon::now()->addWeeks(52);
      $token->save();
      $dt = 525600;

      //     'expires_at' => Carbon::parse(
      //         $tokenResult->token->expires_at)->toDateTimeString()]);
      $response = response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'state'=>$checked,

        'expires_at' => Carbon::parse(
          $tokenResult->token->expires_at)->toDateTimeString()]);
          // $response = new \Illuminate\Http\Response('Test');
          $response->withCookie(cookie('notYru3e', $tokenResult->accessToken, $dt));
          return $response;
        }
      }

      /**
      * Logout user (Revoke the token)
      *
      * @return [string] message
      */
      public function logout(Request $request)
      {
        $request->user()->token()->revoke();
        return response()->json([
          'message' => 'Successfully logged out'
        ]);
      }

      /**
      * Get the authenticated User
      *
      * @return [json] user object
      */
      public function user(Request $request)
      {
        $data = $request->user();
        return $this->responseAPI($data);
      }
    }
