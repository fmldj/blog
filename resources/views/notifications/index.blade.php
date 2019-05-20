@extends('layouts.app')

@section('meta')
<title>消息通知 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container" style="margin-bottom: 400px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">消息通知</div>

                <div class="panel-body">
                            @foreach(Auth::user()->notifications as $notification)
                                    @include('notifications.'.snake_case(class_basename($notification->type)))
                            @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
