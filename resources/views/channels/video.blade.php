@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $video->title }}</div>

                <div class="card-body">
                    <video-js
                        id="video"
                        class="video-js"
                        controls
                        preload="auto"
                        width="680"
                        height="264"
                        data-setup="{}"
                    >
                        <source src='{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8"))}}' type="application/x-mpegURL" />

                        <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                            >supports HTML5 video</a
                        >
                        </p>
                    </video-js>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mt-3">
                                {{ $video->title }}
                            </h4>

                            {{ $video->views }} views
                        </div>

                        <div>
                            <vote-component entity_id="{{$video->id}}" :default_votes="{{$video->votes}}" entity_owner="{{$video->channel->user_id}}"></vote-component>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="media">
                            <img src="" alt="" width="50" height="50" class="rounded-circle mr-3">

                            <div class="media-body ml-2">
                                <h5 class="mt-0 mb-0">{{$video->channel->name}}</h5>
                                <span class="small">Published on {{$video->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger">Subscribe</button>


                </div>
            </div>

            

            @if($video->edittable())
                <form action="{{ route('videos.update', $video->id) }}" method="post">
                    @csrf
                    @method("put")

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-group">
                            <input type="text" name="title" value="{{$video->title}}" class="form-control" style="border:none;">
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea name="description" id="description" cols="3" rows="4" class="form-control">{{$video->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="text-right">
                            <button class="btn btn-primary text-white">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

@section('style')
    <link href="https://vjs.zencdn.net/7.7.5/video-js.css" rel="stylesheet" />
@endsection


@section('script')
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://vjs.zencdn.net/7.7.5/video.js"></script>

    <script src="{{asset('js/player.js')}}"></script>
    <script>
        window.CURRENT_VIDEO = "{{$video->id}}";
    </script>
@endsection