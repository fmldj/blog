@extends('layouts.app')

@section('meta')
<title>私信列表 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container" style="margin-bottom: 400px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">私信列表</div>

                <div class="panel-body">
                        @foreach($message as $key => $messageGroup)
                        <div class="media {{ $messageGroup->last()->readOrUnread() ? 'unread' : '' }}">
                                <div class="media-left">

                                    <a href="#">
                                        @if(Auth::check() && Auth::user()->id == $key)
                                                <img width="50" src="{{ $messageGroup->last()->fromUser->avatar }}" alt="">
                                        @else
                                                <img width="50" src="{{ $messageGroup->last()->toUser->avatar }}" alt="">
                                        @endif
                                    </a>

                                </div>

                                <div class="media-body" style="padding-top: 5px;">
                                    <h5 class="media-heading">
                                        <a href="{{ route('messages.show',['dialog_id' => $messageGroup->last()->dialog_id]) }}">
                                        @if(Auth::check() && Auth::user()->id == $key)
                                                我 与{{ $messageGroup->last()->fromUser->name }}的聊天
                                        @else
                                                我 与{{ $messageGroup->last()->toUser->name }}的聊天
                                        @endif
                                        </a>
                                    </h5>
                                    <p>
                                        <a href="{{ route('messages.show',['dialog_id' => $messageGroup->last()->dialog_id]) }}">{{ $messageGroup->last()->body }} ...</a>
                                    </p>
                                </div>
                        </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
