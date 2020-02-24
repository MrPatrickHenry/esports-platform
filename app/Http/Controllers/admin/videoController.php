<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;
use App\User;
use App\Title;
use App\Traits\apiResponse;

class videoController extends Controller
{
    use apiResponse;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $videoList = Video::all();
        return $this->responseAPI($videList);
    }

    public function store(Request $request)
    {
        $storeVideo = Video::create(
            [
                'title_id' => $request->title_id,
                'thumbnails_ID' => $request->thumbnails_ID,
                'link' => $request->link,
                'title' => $request->title,
                'description' => $request->description
            ]
        );
        return $this->responseAPI($storeVideo);
    }

    public function show($id)
    {
        $input = $request->all();
        $video = Video::findorfail($id);
        return $this->responseAPI($video);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $video = Video::findorfail($request->id);
        $updateNow = $video->update($input);
        return $this->responseAPI('success');
    }

    public function destroy($id)
    {
        $input = $request->all();
        $video = Video::findorfail($request->id);
        $updateNow = $video->update($input);
        $softDelete = $video->delete();
        return $this->responseAPI('success');
    }
}
