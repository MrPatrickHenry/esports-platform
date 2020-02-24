<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use App\Traits\apiResponse;
use Mail;
use DB;
class messages extends Controller
{
  use apiResponse;

    public function store(Request $request){
// Vars
// add to messages table and show in the admin panel

$messages = $request->message;
$name = $request->name;
$company = $request->company;
$email = $request->email;
$country = $request->country;


$messageStore = new Message;
$messageStore->message=$messages;
$messageStore->name=$name;
$messageStore->company=$company;
$messageStore->email=$email;
$messageStore->country=$country;
$messageStore->save();
      //EMAIL Team

      $this->send($messages,$name,$company,$email,$country);
      return $this->responseAPI('true');

    }

    public function send($messages,$name,$company,$email,$country)
    {
// move to notifications in future to do
      $to = 'support@virtualities.co';

        Mail::send('emails.marketingmessage',['messages' => $messages, 'name'=>$name,'company'=>$company,'email'=>$email],
            function ($message) use ($to)
            {
                $message->from('Support@valvr.com', 'Server VAL VR');
                $message->to('support@virtualities.co')->subject('Message from customer');
            });

        return $this->responseAPI('Request Completed');

    }

}
