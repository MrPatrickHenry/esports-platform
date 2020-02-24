<?php

namespace App\Http\Controllers\admin;

use DB;
use App\Traits\apiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class serverStatusController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //Backend health Check

        try {
            DB::connection()->getPdo();

            $healthcheckResponse = [
        "status"=> "200",
        "version"=>"2.1.23.1",
        "message"=>"System is healthy"
      ];
            return $this->responseAPI($healthcheckResponse);
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }
}
