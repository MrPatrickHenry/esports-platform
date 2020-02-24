<?php

namespace App\Http\Controllers\coreControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use App\User;
use App\Notification;
use App\Traits\apiResponse;

class notifications extends Controller
{
  use apiResponse;

public function index(Request $request){
  $userID = $request->id;
  $notificationsUnRead = Notification::where('notifiable_id','=',$userID)->whereNull('read_at')->get();
  $notificationUnReadCount = count($notificationsUnRead);
  $notificationsRead = Notification::where('notifiable_id','=',$userID)->whereNotNull('read_at')->get();
  $notificationReadCount = count($notificationsRead);

$payload = ['unreadNotifications' => $notificationsUnRead,
            'readNotifications' => $notificationsRead,
            'readCount'=> $notificationReadCount,
            'unReadCount' => $notificationUnReadCount,
];
  return $this->responseAPI($payload);

}

public function read($id){
  $notifcation = Notification::findorfail($id);
  $notifcation->unreadNotifications->markAsRead();
  return $this->responseAPI('done');
}
// Soft Delete
public function delete($id){
  $notifcation = Notification::findorfail($id);
  $notifcation->notifications()->delete();
  return $this->responseAPI('done');
}

}
