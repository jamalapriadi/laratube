@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{$channel->name}}

                    <a href="{{route('channel.upload', $channel->id)}}">Upload Videos</a>
                </div>

                <div class="card-body">
                    @if($channel->editable())
                        <form id="update-channel-form" action="{{ route('channels.update', $channel->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            

                            <div class="form-group row justify-content-center">
                                <div class="channel-avatar">
                                        <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 8a3 3 0 1 0 0 6a3 3 0 0 0 0-6zm8-3h-2.4a.888.888 0 0 1-.789-.57l-.621-1.861A.89.89 0 0 0 13.4 2H6.6c-.33 0-.686.256-.789.568L5.189 4.43A.889.889 0 0 1 4.4 5H2C.9 5 0 5.9 0 7v9c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm-8 11a5 5 0 0 1-5-5a5 5 0 1 1 10 0a5 5 0 0 1-5 5zm7.5-7.8a.7.7 0 1 1 0-1.4a.7.7 0 0 1 0 1.4z" fill="#626262"/></svg>
                                        </div>

                                    <img src="{{$channel->image()}}" alt="">
                                </div>
                                
                            </div>

                            <input onchange="document.getElementById('update-channel-form').submit()" type="file" id="image" style="display:none" name="image" class="form-control">

                            <div class="form-group">
                                <label for="name" class="form-control-label">
                                    Name
                                </label>

                                <input type="text" id="name" name="name" value="{{$channel->name}}" class="form-control">
                            </div>

                            <div class="form-group m">
                                <label for="description" class="form-control-label">
                                    Description
                                </label>

                                <textarea name="description" id="description" cols="3" rows="3" class="form-control">
                                    {{$channel->description}}
                                </textarea>
                            </div>

                            @if($errors->any())
                                <ul class="list-group mb-5">
                                    @foreach($errors->all() as $error)
                                        <li class="text-danger list-group-item">{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="form-group">
                                <button class="btn btn-info" type="submit"> Update Channel</button>
                            </div>
                        </form>
                    @else 
                        <div class="form-group row">
                            <img src="{{$channel->image()}}" alt="">
                            <h3 class="text-center">{{$channel->name}}</h3>
                            <p class="text-center">{{$channel->description}}</p>
                        </div>

                        <div class="text-center">
                            <button-subscription :sum_subscription="{{count($channel->subscriptions)}}"></button-subscription>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
