<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Traits\apiResponse;

class userReportingController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $userTypesList = User::groupBy('userType');
        $userTypesCount = $userTypesList -> count();
        return $this->responseAPI($userTypesList);
    }
}
