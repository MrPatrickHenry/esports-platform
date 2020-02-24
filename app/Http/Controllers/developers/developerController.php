<?php

namespace App\Http\Controllers\developers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Developer;
use App\Traits\apiResponse;

class developerController extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $developerList = developer::all();
        return $this->responseAPI($developerList);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $developers = new developer;
        $developers->name=$request->name;
        $developers->logo="62";
        $developers->website=$request->website;
        $developers->email=$request->email;
        $developers->sponsor="0";
        $developers->save();
        return $this->responseAPI('success');
    }
}
