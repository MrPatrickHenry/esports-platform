<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tracking;
use App\Traits\apiResponse;

class trackingController extends Controller
{
    use apiResponse;

    public function index()
    {
        $trackingFullList = Tracking::all();
        return $this->responseAPI($trackingFullList);
    }

    public function store(Request $request)
    {
        $tracking = new Tracking;
        $tracking->files_id=$request->files_id;
        $tracking->user_id=$request->user_id;
        $tracking->impression=$request->impression;
        $tracking->click=$request->click;
        $tracking->userDevice=$request->userDevice;
        $tracking->ipaddress=$request->ipaddress;
        $tracking->save();
        return $this->responseAPI('true');
    }
}
