@extends('layouts.app')

@section('meta')
<title>对话列表 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container" style="margin-bottom:400px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">对话列表</div>

                <div class="panel-body">
                        <form action="{{ route('messages.store') }}" method="post" >
                                {{ csrf_field() }}  
                                <input type="hidden" name="dialog_id" value="{{ $dialog_id }}">
                                <input type="hidden" name="send_to_user_id" value="{{ $send_to_user_id }}">
                                <div class="form-group">
                                    <textarea name="body" class="form-control"></textarea>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-success">发送私信</button>
                                </div>
                        </form>

                        <div class="message-list">
                                @foreach($messages as $message)
                                <div class="media">
                                        <div class="media-left">

                                            <a href="#" style="width: 40px;height: 40px;display: block">
                                                        <img width="40" src="{{ $message->fromUser->avatar }}" alt="">
                                            </a>

                                        </div>

                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="{{ route('messages.show',['dialog_id' => $message->dialog_id]) }}">
                                                        @if(Auth::id() == $message->from_user_id)
                                                            我
                                                        @else
                                                            {{ $message->fromUser->name }}
                                                        @endif

                                            </h4>
                                            <p>
                                                {{ $message->body }}<span class="pull-right">{{ formatTime($message->created_at->format('Y-m-d H:i:s')) }}</span>
                                            </p>
                                        </div>
                                </div>
                                @endforeach
                        </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
