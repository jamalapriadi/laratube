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
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M12.72 2c.15-.02.26.02.41.07c.56.19.83.79.66 1.35c-.17.55-1 3.04-1 3.58c0 .53.75 1 1.35 1h3c.6 0 1 .4 1 1s-2 7-2 7c-.17.39-.55 1-1 1H6V8h2.14c.41-.41 3.3-4.71 3.58-5.27c.21-.41.6-.68 1-.73zM2 8h2v9H2V8z" fill="#626262"/></svg>

                            23k

                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M7.28 18c-.15.02-.26-.02-.41-.07c-.56-.19-.83-.79-.66-1.35c.17-.55 1-3.04 1-3.58c0-.53-.75-1-1.35-1h-3c-.6 0-1-.4-1-1s2-7 2-7c.17-.39.55-1 1-1H14v9h-2.14c-.41.41-3.3 4.71-3.58 5.27c-.21.41-.6.68-1 .73zM18 12h-2V3h2v9z" fill="#626262"/></svg>
                            
                            0
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="media">
                            <img src="" alt="" width="50" height="50" class="rounded-circle mr-3">

                            <div class="media-body ml-2">
                                <h5 class="mt-0 mb-0">Media Heading</h5>
                                <span class="small">Published on 21 Ags 2020</span>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger">Subscribe</button>


                </div>
            </div>
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