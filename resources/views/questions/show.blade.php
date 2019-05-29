@extends('layouts.app')

@section('meta')
<title>{{ $data->title}} - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <h4 style="display: inline-block;">{{ $data->title}}</h4>

                        @foreach($data->topics as $t)
                            <a href="{{ route('topic',['topic_id' => $t->id]) }}" class="topic">{{ $t->name }}</a>
                        @endforeach


                </div>

                <div class="panel-body">
                        {!! $data->body !!}
                </div>                 

                @if(Auth::check() && Auth::user()->owns($data))
                <div class="actions">

                    <span class="edit"><a href="{{ route('questions.edit',['id' => $data->id]) }}">编辑</a></span>

                    <form action="{{ route('questions.delete',['id' => $data->id]) }}" method="post" class="delete-form">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button class="button is-naked delete-button">删除</button>

                    </form>

                </div>
                @endif

                <div class="actions">
                    <comment-component type="question" model="{{ $data->id }}" count="{{ $data->comments()->count() }}">
                    </comment-component>
                    <div class="update-time">编辑于： {{ $data->updated_at }}</div>

                </div>

                
            </div>


            <div class="ui message basic text-center pt-2">
                            <div class="pt-0">
                                <div class="ui small horizontal list topic-voted-users" style="font-size:16px;display: flex;">
                                            <div class="item" style="font-size: 15px;margin-right: 12px;font-size: 15px;margin-right: 12px;display: inline-flex;flex-shrink: 0;line-height: 26px;">
                                                

                                            <a class="item ui topic-vote ui action  rm-link-color text-mute rm-tdu" id="topic-vote-25181" data-id="25181" href="#" title="Vote Up">
                                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="count vote-count">{{ $count }}</span> 人点赞
                                            </a>

                                            </div>
                                            <div class="users" style="display: inline-flex;-webkit-box-flex: 1;-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;-ms-flex-wrap: wrap;flex-wrap: wrap;overflow: hidden;height: 42px;">

                                                @foreach($likes as $k => $v)
                                                <a class="item" style="margin-left: 2px;" href="{{ route('people.index', ['user' => $v[0]]) }}">
                                                    <img class="ui image avatar translator" src="{{ $v[2] }}" style="width: 34px;height: 34px;">
                                                </a>
                                                @endforeach


                                            </div>
                            </div>                
                        </div>
                                            <div>
                                                    <div class="social-share" data-initialized="true" style="text-align: center;margin-right: 10px"  data-url="{{ route('questions.show',['id' =>$data->id])}}"  data-title="{{ $data->title }}" data-description="{{ $data->title }}" data-source="djfml">
                                                        <a href="#" class="social-share-icon icon-weibo"></a>
                                                        <a href="#" class="social-share-icon icon-wechat"></a>
                                                        <a href="#" class="social-share-icon icon-qq"></a>
                                                        <a href="#" class="social-share-icon icon-qzone"></a>
                                                        <a href="#" class="social-share-icon icon-douban"></a>
                                                    </div>                                    
                                            </div>




            </div>



        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading question-follow question-follow-flex">
                    <div class="flexs">
                                <h2>{{ $data->look }}</h2>
                                <span>被浏览</span>
                    </div>
                    <div class="flexs">
                                <div class="border-flexs">
                                <h2>{{ $data->followers_count }}</h2>
                                <span>关注者</span>                                    
                                </div>

                    </div>
                </div>
                <div class="panel-body question-follow">

                	@if(Auth::check() && Auth::user()->id !== $data->user_id || !Auth::check())
	                    <question-component question="{{ $data->id }}" followers_count="{{ $data->followers_count }}"></question-component>                
                    @endif


                    <a name="5F" href="#5F" class="btn btn-sm btn-default">撰写答案</a>
                </div>

            </div>
        </div>





        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">

                    {{ $data->answers_count }} 个答案

                </div>
                <div class="panel-body">

                            @foreach($data->answer as $answer)

                                <div class="media">

                                    <div class="media-left">
                                        <user-vote-component answer="{{ $answer->id }}" count="{{ $answer->votes_count }}"></user-vote-component>
                                    </div>

                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{{ route('people.index',['user' =>$answer->user_id])}}">{{$answer->user->name}}</a>
                                        </h4>
                                        <div>
                                            {!! $answer->body !!}
                                        </div>
                                        
                                    </div>

                                    <div class="actions">
                                        <comment-component type="answer" model="{{ $answer->id }}" count="{{ $answer->comments()->count() }}">
                                        </comment-component>
                                        <div class="update-time">回答于： {{ $data->updated_at }}</div> 
                                    </div>

                                </div>
                            @endforeach

                            @if(Auth::check())
                                <a href="#5F"></a>
                                <form style="margin-top: 30px;" action="{{ route('answer.store',['id' => $data->id]) }}" method="post">

                                    {!! csrf_field() !!}

                                    <div class="form-group {{$errors->has('body')?'has-error':''}}">
                                     <script id="container" style="height:200px" name="body" type="text/plain"></script>
                                     @if ($errors->has('body'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                     @endif                                    

                                    </div>


                                    <button class="btn btn-success pull-right" type="submit">提交答案</button>
                                </form>
                            @else
                                <a style="margin-top: 30px;" href="{{ route('login') }}" class="btn btn-success btn-block">登录提交答案</a>
                            @endif 


                </div>                 

                
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading question-follow">
                    <h5>关于作者</h5>
                </div>
                <div class="panel-body question-follow">
                    <div class="media">
                        <div class="media-left">
                            
                            <a href="#">
                                    <img width="36" src="{{ $data->user->avatar }}" alt="{{ $data->user->name }}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="#">{{ $data->user->name }}</a>
                            </h4>
                        </div>

                        <div class="user-statics">
                            <div class="statics-item text-center">
                                <div class="statics-text">问题</div>
                                <div class="statics-count">{{ $data->user->questions_count }}</div>
                            </div>

                            <div class="statics-item text-center">
                                <div class="statics-text">回答</div>
                                <div class="statics-count">{{ $data->user->answers_count }}</div>
                            </div>

                            <div class="statics-item text-center">
                                <div class="statics-text">关注者</div>
                                <div class="statics-count">{{ $data->user->follwers_count }}</div>
                            </div>

                        </div>

                    </div>
                    		@if(Auth::check() && Auth::user()->id !== $data->user_id || !Auth::check())
		                            <user-follower-component user_id="{{ $data->user_id }}"></user-follower-component>
		                            <send-message-component user_id="{{ $data->user_id }}"></send-message-component>                    
                    		@endif


                </div>

            </div>
        </div>



    </div>
</div>

@section('scripts')
@include('vendor.ueditor.assets')
<script type="text/javascript">
var ue = UE.getEditor('container', {
    toolbars: [
            ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
        ],
    elementPathEnabled: false,
    enableContextMenu: false,
    autoClearEmptyNode:true,
    wordCount:false,
    imagePopup:false,
    autotypeset:{ indent: true,imageBlockLine: 'center' }
});
</script>
@stop

@endsection
