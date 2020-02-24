<?php

namespace App\Http\Controllers\coreControllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UploadAssetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Files;
use App\Traits\apiResponse;

class filesController extends Controller
{
    use apiResponse;

    public function store(Request $request)
    {
        $path = $request->file('logo')->store('logos', 'gcs');

        $fileStore = Files::create(array(
        'user_id' => $request->userID,
    'file_name'=> $request->title,
    'type'=> $request->logo->extension(),
    'category_id' => $request->category_id,
    'path'=>$path,
    'is_public'=>'1'));
        return response()->json($fileStore, 200);
    }

    public function show($id)
    {
        $filesShow = Files::where('id', $id)->get();
        return $this->responseAPI($filesShow);
    }
}
