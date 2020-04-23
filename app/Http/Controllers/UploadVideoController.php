<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Jobs\Videos\ConvertForStreaming;
use App\Jobs\Videos\CreateVideoThumbnail;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        return view('channels.upload',[
            'channel'=>$channel
        ]);
    }

    public function store(Channel $channel)
    {
        $video = $channel->videos()->create(
            [
                'title' => request()->title,
                'description' => request()->description,
                'path' => request()->video->store("channels/{$channel->id}/videos")
            ]
        );

        $this->dispatch(new CreateVideoThumbnail($video));

        $this->dispatch(new ConvertForStreaming($video));

        return $video;
    }
}
