<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Http\Requests\Videos\UpdateVideoRequest;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        if(request()->wantsJson()){
            return $video;
        }

        return view('channels.video',compact('video'));
        
    }

    public function updateViews(Video $video)
    {
        $video->increment('views');

        return response()->json([]);
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update(
            $request->only(
                [
                    'title','description'
                ]
            )
        );

        return redirect()->back();
    }
}
