@extends('layouts.app')

@section('content')
<div class="container">
    <channel-uploads :channels="{{$channel}}"></channel-uploads>
</div>
@endsection
