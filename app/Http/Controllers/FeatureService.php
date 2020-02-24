<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;
use App\User;
use App\Traits\apiResponse;

class FeatureService extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Feature::where('user_Type', $request->userType)->get();
        return $this->responseAPI($data);
    }
}
