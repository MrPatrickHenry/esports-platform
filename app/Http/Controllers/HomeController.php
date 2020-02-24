<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\User;

class HomeController extends Controller
{
      use Notifiable;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function notify(){
      $user = \App\User::find(1);

     $details = [
             'greeting' => 'Hi Artisan',
             'body' => 'This is our example notification tutorial',
             'thanks' => 'Thank you for visiting codechief.org!',
     ];

     $user->notify(new \App\Notifications\approvedToHost($details));
return 'done';


   }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
