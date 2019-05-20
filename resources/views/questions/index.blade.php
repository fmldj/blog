@extends('layouts.app')

@section('meta')
<title>首页 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop


@section('content')
<div class="Topstory-container">
    <div class="Topstory-mainColumn">
        <div class="Card Topstory-noMarginCard Topstory-tabCard">
            <ul role="tablist" class="Tabs">
                <li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-recommend">
                    <a class="Tabs-link {{ (isset($recommend)&&$recommend=1) ? 'is-active' : '' }}" href="/">推荐</a>
                </li>
                <li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-follow">

                    <a class="Tabs-link {{ (isset($follow)&&$follow=1) ? 'is-active' : '' }}" href="/follow">关注</a>
                </li>
                <li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-hot">
                    <a class="Tabs-link {{ (isset($hot)&&$hot=1) ? 'is-active' : '' }}" href="/hot">热榜</a>
                </li>
            </ul>
            <div>
                <div>
                    <div class="Sticky"></div>
                </div>
            </div>
        </div>
        <div id="TopstoryContent" class="Topstory-content">
            <div class="color-white ListShortcut">

                @if($type == 'recommend')
                <div class="col-md-offset-1 padding-top-30 padding-bottom-30">
                    @foreach($questions as $question)
                        <div class="media padding-bottom-20">
                            <div class="media-left">
                                <a href="{{ route('people.index',['id' => $question->user->id]) }}">
                                    <img class="border-radis-img" width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="{{ route('questions.show',['id' =>$question->id])}}">{{ $question->title }}</a>
                                    <span class="f_right margin-right-10 font-size-12">{{ formatTime($question->created_at) }}</span>
                                </h4>
                                <div class="coverContent">
                                        @if($question->cover)
                                        <div class="coverImg">
                                            <img src="{{ $question->cover }}">
                                        </div>
                                        @endif

                                        <div class="question-content">
                                            <span>{!! $question->body !!}</span>


                                        </div>                                    

                                </div>
                                <div style="display: flex;">

                                <div style="flex: 1">
                                    @if(Auth::check() && Auth::user()->id !== $question->user->id || !Auth::check()  )                    
                                        <question-component question="{{ $question->id }}" followers_count="{{ $question->followers_count }}"></question-component>
                                    @endif

                                        <button type="button" class="btn btn-default btn-sm margin-left-10">
                                                <span class="glyphicon glyphicon-user"></span> {{ $question->user->name }}
                                        </button>

                                        <like-component status="{{ $question->like_self_user }}" question_id="{{ $question->id }}" like_count="{{ $question->likes_count }}" class="margin-left-10"></like-component>

                                        <comment-component class="margin-left-10" type="question" model="{{ $question->id }}" count="{{ $question->comments()->count() }}"></comment-component>
                                </div>

                                <div>
                                        <div class="social-share" data-initialized="true" style="text-align: center;margin-right: 10px"  data-url="{{ route('questions.show',['id' =>$question->id])}}"  data-title="{{ $question->title }}" data-description="{{ $question->title }}" data-source="djfml">
                                            <a href="#" class="social-share-icon icon-weibo"></a>
                                            <a href="#" class="social-share-icon icon-wechat"></a>
                                            <!-- <a href="#" class="social-share-icon icon-qq"></a> -->
                                            <a href="#" class="social-share-icon icon-qzone"></a>
                                            <a href="#" class="social-share-icon icon-douban"></a>
                                        </div>                                    
                                </div>



                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
                @endif


                @if($type == 'follow')
                <div class="col-md-offset-1 padding-top-30 padding-bottom-30">
                    @if(Auth::check())

                        @if($is_exist_following_user)
                            @foreach($questions as $question)
                                <div class="Topstory-newUserFollowItemHeader">
                                    <div class="Topstory-newUserFollowItemHeaderAuthorInfo">
                                        <span class="UserLink">
                                            <div class="Popover">
                                                <div id="Popover218-toggle">
                                                    <a class="UserLink-link" target="_blank" href="{{ route('people.index',['user' => $question->id]) }}">
                                                        <img class="Avatar Avatar--medium UserLink-avatar" width="40" height="40" src="{{$question->avatar}}" alt="{{$question->name}}">
                                                    </a>
                                                </div>
                                            </div>
                                        </span>
                                        <div class="Topstory-newUserFollowItemHeaderAuthorInfoText">
                                            <span class="Topstory-newUserFollowItemHeaderAuthorBasicInfo">
                                                <span class="UserLink Topstory-newUserFollowItemHeaderAuthorInfoName">
                                                    <div class="Popover">
                                                        <div id="Popover219-toggle">
                                                            <a class="UserLink-link" target="_blank" href="{{ route('people.index',['user' => $question->id]) }}">
                                                                {{$question->name}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <a class="UserLink-badge" data-tooltip="优秀回答者 · 已认证的个人" href="{{ route('questions.show',['id' =>$question->id])}}" target="_blank">
                                                        <span style="display: inline-flex; align-items: center;">​
                                                            <svg class="Zi Zi--BadgeCG" fill="currentColor" viewBox="0 0 24 24" width="18" height="18"><g fill="none" fill-rule="evenodd"><path fill="#0F88EB" d="M12.055 3.172c.21-.165.397-.344.555-.532l-.127.152c.891-1.065 2.319-1.056 3.195.027l-.125-.153c.872 1.08 2.696 1.856 4.083 1.733l-.197.017c1.383-.122 2.386.893 2.239 2.279l.021-.198c-.147 1.381.593 3.218 1.661 4.113l-.152-.127c1.065.891 1.056 2.319-.027 3.195l.154-.125c-1.08.872-1.856 2.696-1.734 4.084l-.017-.197c.123 1.382-.893 2.385-2.279 2.238l.198.021c-1.38-.147-3.218.593-4.113 1.661l.127-.152c-.891 1.065-2.319 1.057-3.195-.027l.125.154a3.716 3.716 0 0 0-.503-.506c.975-.77 2.422-1.25 3.559-1.13l-.198-.021c1.386.147 2.402-.856 2.279-2.238l.017.197c-.122-1.388.655-3.212 1.734-4.084l-.154.125c1.083-.876 1.092-2.304.027-3.195l.152.127c-1.068-.895-1.808-2.732-1.66-4.113l-.022.198c.147-1.386-.856-2.4-2.24-2.279l.198-.017c-1.159.103-2.622-.422-3.58-1.227z"></path><path fill="#FF9500" d="M19.21 10.483l.151.127c-1.069-.895-1.809-2.732-1.662-4.113l-.02.197c.146-1.386-.857-2.4-2.24-2.278l.197-.018c-1.387.124-3.21-.653-4.083-1.732l.125.153c-.876-1.083-2.304-1.092-3.195-.028l.127-.152c-.894 1.068-2.733 1.808-4.113 1.663l.198.02c-1.386-.147-2.4.857-2.279 2.24L2.4 6.363c.122 1.387-.655 3.21-1.734 4.084l.154-.126c-1.083.877-1.092 2.304-.027 3.194L.64 13.39c1.068.894 1.808 2.733 1.661 4.112l.021-.196c-.147 1.385.856 2.401 2.24 2.28l-.198.015c1.387-.122 3.211.655 4.083 1.734l-.124-.154c.184.228.396.397.62.53a1.89 1.89 0 0 0 1.972 0c.215-.127.421-.287.602-.503l-.127.152c.895-1.068 2.733-1.808 4.113-1.66l-.198-.022c1.387.147 2.402-.856 2.28-2.238l.016.197c-.122-1.389.655-3.212 1.734-4.084l-.154.124c1.083-.876 1.092-2.303.028-3.194"></path><path fill="#FFF" d="M14.946 11.082l-2.362 2.024.721 3.025c.128.534-.144.738-.617.45l-2.654-1.623L7.38 16.58c-.468.286-.746.09-.617-.449l.721-3.025-2.362-2.024c-.417-.357-.317-.68.236-.726l3.101-.248 1.194-2.872c.211-.507.55-.512.763 0l1.195 2.872 3.1.248c.547.044.657.365.236.726"></path></g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </span>&nbsp;，<div class="Topstory-newUserFollowItemHeaderAuthorInfoDescription">{{$question->settings['bio']}}</div>
                                            </span>
                                            <span class="Topstory-newUserFollowItemExtraInfo">{{$question->answers_count}} 回答 ·&nbsp;{{$question->comments_count}} 评论 ·&nbsp;{{$question->follwers_count}} 关注者</span>
                                        </div>
                                    </div>
                                    <user-follower-component style="margin-right: 10px;" user_id='{{$question->id}}'></user-follower-component>
                                </div>

                                <div class="media padding-bottom-20">
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{{ route('questions.show',['id' =>$question->id])}}">{{ $question->question_title }}</a>
                                        </h4>
                                        <div class="coverContent">
                                                @if($question->cover)
                                                <div class="coverImg">
                                                    <img src="{{ $question->cover }}">
                                                </div>
                                                @endif

                                                <div class="question-content">
                                                    <span>{!! $question->question_body !!}</span>


                                                </div>                                    

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        @else

                                <div class="Topstory-newUserFollowCountPanel" style="margin-bottom: 20px;">
                                    <svg width="150" height="120" viewBox="0 0 150 120" class="Topstory-newUserFollowCountPanelIcon" fill="currentColor"><g fill="none" fill-rule="evenodd"><path fill="#EBEEF5" d="M44 31.005v55.99A3.003 3.003 0 0 0 47.003 90h53.994A3.005 3.005 0 0 0 104 86.995v-55.99A3.003 3.003 0 0 0 100.997 28H47.003A3.005 3.005 0 0 0 44 31.005zm-3 0A6.005 6.005 0 0 1 47.003 25h53.994A6.003 6.003 0 0 1 107 31.005v55.99A6.005 6.005 0 0 1 100.997 93H47.003A6.003 6.003 0 0 1 41 86.995v-55.99z" fill-rule="nonzero"></path><path fill="#F7F8FA" d="M59 50a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm12-9.5c0-.828.68-1.5 1.496-1.5h9.008c.826 0 1.496.666 1.496 1.5 0 .828-.68 1.5-1.496 1.5h-9.008A1.495 1.495 0 0 1 71 40.5zm0 7c0-.828.667-1.5 1.5-1.5h21c.828 0 1.5.666 1.5 1.5 0 .828-.667 1.5-1.5 1.5h-21c-.828 0-1.5-.666-1.5-1.5zM59 73a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm12-9.5c0-.828.68-1.5 1.496-1.5h9.008c.826 0 1.496.666 1.496 1.5 0 .828-.68 1.5-1.496 1.5h-9.008A1.495 1.495 0 0 1 71 63.5zm0 7c0-.828.667-1.5 1.5-1.5h21c.828 0 1.5.666 1.5 1.5 0 .828-.667 1.5-1.5 1.5h-21c-.828 0-1.5-.666-1.5-1.5z"></path></g>
                                    </svg>
                                    <div class="Topstory-newUserFollowCountPanelText">还没有关注的人，为你推荐以下用户</div>
                                </div>



                            @foreach($rand_user as $question)
                                <div class="Topstory-newUserFollowItemHeader">
                                    <div class="Topstory-newUserFollowItemHeaderAuthorInfo">
                                        <span class="UserLink">
                                            <div class="Popover">
                                                <div id="Popover218-toggle">
                                                    <a class="UserLink-link" target="_blank" href="{{ route('people.index',['user' => $question->id]) }}">
                                                        <img class="Avatar Avatar--medium UserLink-avatar" width="40" height="40" src="{{$question->avatar}}" alt="{{$question->name}}">
                                                    </a>
                                                </div>
                                            </div>
                                        </span>
                                        <div class="Topstory-newUserFollowItemHeaderAuthorInfoText">
                                            <span class="Topstory-newUserFollowItemHeaderAuthorBasicInfo">
                                                <span class="UserLink Topstory-newUserFollowItemHeaderAuthorInfoName">
                                                    <div class="Popover">
                                                        <div id="Popover219-toggle">
                                                            <a class="UserLink-link" target="_blank" href="{{ route('people.index',['user' => $question->id]) }}">
                                                                {{$question->name}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <a class="UserLink-badge" data-tooltip="优秀回答者 · 已认证的个人" href="{{ route('questions.show',['id' =>$question->id])}}" target="_blank">
                                                        <span style="display: inline-flex; align-items: center;">​
                                                            <svg class="Zi Zi--BadgeCG" fill="currentColor" viewBox="0 0 24 24" width="18" height="18"><g fill="none" fill-rule="evenodd"><path fill="#0F88EB" d="M12.055 3.172c.21-.165.397-.344.555-.532l-.127.152c.891-1.065 2.319-1.056 3.195.027l-.125-.153c.872 1.08 2.696 1.856 4.083 1.733l-.197.017c1.383-.122 2.386.893 2.239 2.279l.021-.198c-.147 1.381.593 3.218 1.661 4.113l-.152-.127c1.065.891 1.056 2.319-.027 3.195l.154-.125c-1.08.872-1.856 2.696-1.734 4.084l-.017-.197c.123 1.382-.893 2.385-2.279 2.238l.198.021c-1.38-.147-3.218.593-4.113 1.661l.127-.152c-.891 1.065-2.319 1.057-3.195-.027l.125.154a3.716 3.716 0 0 0-.503-.506c.975-.77 2.422-1.25 3.559-1.13l-.198-.021c1.386.147 2.402-.856 2.279-2.238l.017.197c-.122-1.388.655-3.212 1.734-4.084l-.154.125c1.083-.876 1.092-2.304.027-3.195l.152.127c-1.068-.895-1.808-2.732-1.66-4.113l-.022.198c.147-1.386-.856-2.4-2.24-2.279l.198-.017c-1.159.103-2.622-.422-3.58-1.227z"></path><path fill="#FF9500" d="M19.21 10.483l.151.127c-1.069-.895-1.809-2.732-1.662-4.113l-.02.197c.146-1.386-.857-2.4-2.24-2.278l.197-.018c-1.387.124-3.21-.653-4.083-1.732l.125.153c-.876-1.083-2.304-1.092-3.195-.028l.127-.152c-.894 1.068-2.733 1.808-4.113 1.663l.198.02c-1.386-.147-2.4.857-2.279 2.24L2.4 6.363c.122 1.387-.655 3.21-1.734 4.084l.154-.126c-1.083.877-1.092 2.304-.027 3.194L.64 13.39c1.068.894 1.808 2.733 1.661 4.112l.021-.196c-.147 1.385.856 2.401 2.24 2.28l-.198.015c1.387-.122 3.211.655 4.083 1.734l-.124-.154c.184.228.396.397.62.53a1.89 1.89 0 0 0 1.972 0c.215-.127.421-.287.602-.503l-.127.152c.895-1.068 2.733-1.808 4.113-1.66l-.198-.022c1.387.147 2.402-.856 2.28-2.238l.016.197c-.122-1.389.655-3.212 1.734-4.084l-.154.124c1.083-.876 1.092-2.303.028-3.194"></path><path fill="#FFF" d="M14.946 11.082l-2.362 2.024.721 3.025c.128.534-.144.738-.617.45l-2.654-1.623L7.38 16.58c-.468.286-.746.09-.617-.449l.721-3.025-2.362-2.024c-.417-.357-.317-.68.236-.726l3.101-.248 1.194-2.872c.211-.507.55-.512.763 0l1.195 2.872 3.1.248c.547.044.657.365.236.726"></path></g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </span>&nbsp;，<div class="Topstory-newUserFollowItemHeaderAuthorInfoDescription">{{$question->settings['bio']}}</div>
                                            </span>
                                            <span class="Topstory-newUserFollowItemExtraInfo">{{$question->answers_count}} 回答 ·&nbsp;{{$question->comments_count}} 评论 ·&nbsp;{{$question->follwers_count}} 关注者</span>
                                        </div>
                                    </div>
                                    <user-follower-component style="margin-right: 10px;" user_id='{{$question->id}}'></user-follower-component>
                                </div>

                                <div class="media padding-bottom-20">
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{{ route('questions.show',['id' =>$question->id])}}">{{ $question->question_title }}</a>
                                        </h4>
                                        <div class="coverContent">
                                                @if($question->cover)
                                                <div class="coverImg">
                                                    <img src="{{ $question->cover }}">
                                                </div>
                                                @endif

                                                <div class="question-content">
                                                    <span>{!! $question->question_body !!}</span>


                                                </div>                                    

                                        </div>

                                    </div>

                                </div>
                            @endforeach












                        @endif
                    @else

                        <div class="Topstory-newUserFollowCountPanel">
                            <svg width="150" height="120" viewBox="0 0 150 120" class="Topstory-newUserFollowCountPanelIcon" fill="currentColor"><g fill="none" fill-rule="evenodd"><path fill="#EBEEF5" d="M44 31.005v55.99A3.003 3.003 0 0 0 47.003 90h53.994A3.005 3.005 0 0 0 104 86.995v-55.99A3.003 3.003 0 0 0 100.997 28H47.003A3.005 3.005 0 0 0 44 31.005zm-3 0A6.005 6.005 0 0 1 47.003 25h53.994A6.003 6.003 0 0 1 107 31.005v55.99A6.005 6.005 0 0 1 100.997 93H47.003A6.003 6.003 0 0 1 41 86.995v-55.99z" fill-rule="nonzero"></path><path fill="#F7F8FA" d="M59 50a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm12-9.5c0-.828.68-1.5 1.496-1.5h9.008c.826 0 1.496.666 1.496 1.5 0 .828-.68 1.5-1.496 1.5h-9.008A1.495 1.495 0 0 1 71 40.5zm0 7c0-.828.667-1.5 1.5-1.5h21c.828 0 1.5.666 1.5 1.5 0 .828-.667 1.5-1.5 1.5h-21c-.828 0-1.5-.666-1.5-1.5zM59 73a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm12-9.5c0-.828.68-1.5 1.496-1.5h9.008c.826 0 1.496.666 1.496 1.5 0 .828-.68 1.5-1.496 1.5h-9.008A1.495 1.495 0 0 1 71 63.5zm0 7c0-.828.667-1.5 1.5-1.5h21c.828 0 1.5.666 1.5 1.5 0 .828-.667 1.5-1.5 1.5h-21c-.828 0-1.5-.666-1.5-1.5z"></path></g>
                            </svg>
                            <div class="Topstory-newUserFollowCountPanelText">请<a href="{{ route('login') }}">登录</a>在关注喔！</div>
                        </div>
                        
                    @endif
                </div>
                @endif






                @if($type == 'hot')
                <div class="col-md-offset-1 padding-top-30 padding-bottom-30">
                    @foreach($questions as $k => $question)
                        <section class="HotItem">
                            <div class="HotItem-index">
                                <div class="HotItem-rank {{$k<3?'HotItem-hot':''}}">{{ $k+1 }}</div>
                            </div>
                            <div class="HotItem-content">
                                <a href="{{ route('questions.show',['id' => $question->id]) }}" title="{{ $question->title }}" target="_blank" rel="noopener noreferrer">
                                    <h2 class="HotItem-title">{{ $question->title }}</h2>
                                    <div class="HotItem-excerpt HotItem-excerpt--multiLine">
                                         {!! $question->body !!}
                                    </div>
                                </a>
                                <div class="HotItem-metrics HotItem-metrics--bottom">
                                    <svg class="Zi Zi--Hot" fill="currentColor" viewBox="0 0 24 24" width="18" height="18"><defs><linearGradient id="id-2014200654-a" x1="63.313%" x2="46.604%" y1="-13.472%" y2="117.368%"><stop offset="2.35%" stop-color="#EC471E"></stop><stop offset="100%" stop-color="#FF6DC4"></stop></linearGradient></defs><path fill="url(#id-2014200654-a)" d="M14.553 20.78c.862-.651 1.39-1.792 1.583-3.421.298-2.511-.656-4.904-2.863-7.179.209 2.291.209 3.73 0 4.314-.41 1.143-1.123 1.983-1.91 2.03-1.35.079-2.305-.512-2.863-1.774-.676 1.25-.782 2.556-.318 3.915.31.906.94 1.684 1.89 2.333C7.144 20.131 5 17.336 5 14.022c0-2.144.898-4.072 2.325-5.4.062 2.072.682 3.598 2.13 4.822-.67-1.112-.734-2.11-.734-3.517 0-3.253 2.067-6.007 4.913-6.927a7.35 7.35 0 0 0 2.157 4.918C17.722 9.214 19 11.463 19 14.022c0 3.073-1.844 5.7-4.447 6.758z" fill-rule="evenodd"></path>
                                    </svg>1492 万热度
                                    <span class="HotItem-action">
                                        <div class="Popover ShareMenu">

                                        </div>
                                    </span>
                                </div>
                            </div>
                            <a class="HotItem-img" href="" title="{{ $question->title }}" target="_blank" rel="noopener noreferrer">
                                @if($question->cover)
                                    <img src="{{ $question->cover }}" alt="{{ $question->title }}">
                                @else
                                    <div style="height: 105px;width: 190px"></div>
                                @endif
                                
                            </a>
                        </section> 
                    @endforeach                   
                </div>
                @endif 

            </div>
        </div>
    </div>


    <div class="GlobalSideBar">
        <div>
            <div class="Sticky">
                <div class="Card">
                    <div class="GlobalWrite">
                        <div class="GlobalWrite-nav">
                            <a class="GlobalWrite-navItem" href="{{ route('answer.index') }}" target="_blank" rel="noopener noreferrer" title="回答"><svg class="Zi Zi--Paper GlobalWrite-navIcon" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M9.273 5.63c-1.103 0-1.439.064-1.782.243a1.348 1.348 0 0 0-.576.564c-.183.336-.248.664-.248 1.743v6.64c0 1.079.065 1.407.248 1.743.135.247.323.431.576.564.343.18.68.243 1.782.243h5.454c1.103 0 1.439-.064 1.782-.243.253-.133.44-.317.576-.564.183-.336.248-.664.248-1.743V8.18c0-1.079-.065-1.407-.248-1.743a1.348 1.348 0 0 0-.576-.564c-.343-.18-.68-.243-1.782-.243H9.273zm0-1.63h5.454c1.486 0 2.025.151 2.568.436.543.284.97.7 1.26 1.232.29.532.445 1.059.445 2.512v6.64c0 1.453-.155 1.98-.445 2.512-.29.531-.717.948-1.26 1.232-.543.285-1.082.436-2.568.436H9.273c-1.486 0-2.025-.151-2.568-.436a2.997 2.997 0 0 1-1.26-1.232C5.155 16.8 5 16.273 5 14.82V8.18c0-1.453.155-1.98.445-2.512.29-.531.717-.948 1.26-1.232C7.248 4.15 7.787 4 9.273 4zM8.5 8.076v1.467h7V8.076h-7zm0 2.609v1.467h7v-1.467h-7zm0 2.608v1.468h4.667v-1.468H8.5z"></path></svg><div class="GlobalWrite-navTitle">写回答</div></a>

                            <a class="GlobalWrite-navItem" href="{{ route('questions.create') }}" target="_blank" title="提问题"><svg class="Zi Zi--WriteArticle GlobalWrite-navIcon" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M15.764 7.279l-3.76 3.765c-.428.43-.555.567-.667.713a1.666 1.666 0 0 0-.208.348c-.076.167-.137.344-.314.926l-.073.243.242-.074c.58-.177.757-.238.925-.314.13-.06.232-.12.347-.209.146-.112.282-.239.712-.668l3.759-3.766-.963-.964zm.963-.965l.963.965.685-.686c.167-.168.227-.263.253-.349a.187.187 0 0 0 0-.12c-.026-.086-.086-.18-.253-.348l-.148-.148c-.167-.167-.262-.228-.348-.254a.187.187 0 0 0-.12 0c-.085.026-.18.087-.347.254l-.685.686zm.87 5.471l1.702-1.705v5.549c0 1.52-.158 2.07-.455 2.626a3.096 3.096 0 0 1-1.287 1.29c-.555.297-1.105.455-2.623.455h-5.57c-1.517 0-2.068-.158-2.622-.455a3.096 3.096 0 0 1-1.287-1.29C5.158 17.7 5 17.15 5 15.63v-5.58c0-1.52.158-2.071.455-2.627a3.096 3.096 0 0 1 1.287-1.289c.554-.297 1.105-.455 2.622-.455h3.497l-1.702 1.705H9.364c-1.126 0-1.47.066-1.82.254-.258.138-.45.33-.588.59-.188.35-.254.694-.254 1.822v5.58c0 1.128.066 1.472.254 1.822.138.259.33.452.588.59.35.188.694.254 1.82.254h5.57c1.127 0 1.47-.066 1.82-.254.258-.138.45-.331.589-.59.187-.35.253-.694.253-1.822v-3.844zm1.593-7.121l.148.147c.33.33.502.616.594.918.09.301.09.61 0 .911-.092.302-.265.587-.594.917l-5.408 5.416c-.486.487-.648.635-.845.786a3.02 3.02 0 0 1-.614.37c-.226.102-.433.176-1.091.376l-.852.26a1.021 1.021 0 0 1-1.275-1.277l.26-.854c.2-.659.273-.866.375-1.092.103-.227.218-.418.369-.616.15-.197.299-.36.785-.846l5.407-5.416c.33-.33.614-.504.915-.595.301-.092.61-.092.91 0 .301.09.586.264.916.595z"></path></svg><div class="GlobalWrite-navTitle">写文章</div></a>

<!--                             <div class="GlobalWrite-navItem"><svg class="Zi Zi--WritePin GlobalWrite-navIcon" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M16.63 6.02V4h1.35v2.02H20v1.35h-2.02V9.4h-1.35V7.36H14.6V6.02h2.03zm-.17 4.9h1.7v4.76c0 1.5-.17 2.05-.46 2.6-.3.55-.73.98-1.28 1.27-.54.3-1.1.45-2.6.45h-5.5c-1.5 0-2.05-.16-2.6-.45-.55-.3-.98-.72-1.27-1.27-.3-.55-.45-1.1-.45-2.6v-5.5c0-1.5.16-2.06.45-2.6.3-.55.72-.98 1.27-1.28.55-.3 1.1-.45 2.6-.45h4.78v1.7H8.3c-1.12 0-1.46.05-1.8.24-.26.1-.45.3-.58.55-.2.35-.26.7-.26 1.8v5.5c0 1.13.07 1.47.26 1.8.13.27.32.46.58.6.34.18.68.25 1.8.25h5.5c1.12 0 1.46-.06 1.8-.25.27-.13.46-.32.6-.58.18-.34.24-.68.24-1.8V10.9l.02.02zm-3.86-.22c.7-.16 1.45.06 1.98.6.83.83.83 2.2 0 3.04l-.03.03c-.84.85-2.2.85-3.04 0l-1.92-2a.628.628 0 0 0-.88 0l-.04.04c-.25.28-.25.7 0 .95.15.16.37.22.57.17.4-.1.82.18.9.58.1.4-.16.82-.57.9-.7.17-1.46-.04-1.98-.58-.83-.85-.83-2.2 0-3.06l.03-.02c.86-.85 2.2-.85 3.05 0l1.93 1.95c.24.25.63.25.87 0l.03-.02a.67.67 0 0 0 0-.93.687.687 0 0 0-.58-.17c-.4.1-.8-.16-.9-.57-.1-.4.16-.8.57-.9l.01-.01z"></path></svg>
                                <div class="GlobalWrite-navTitle">写想法</div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>

@section('scripts')
@stop


@endsection