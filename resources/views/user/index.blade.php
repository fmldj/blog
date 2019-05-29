@extends('layouts.app')

@section('meta')
<title>我的主页 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
<div id="ProfileHeader" class="ProfileHeader">
    <div class="Card">

        <bg-component cover="{{ $user->bg }}" is_self="{{Auth::check() && (Auth::user()->id == $user->id) ? 1 : 0}}"></bg-component>


        <div class="ProfileHeader-wrapper">
            <div class="ProfileHeader-main">
                <div class="UserAvatar ProfileHeader-avatar" style="top: -57px;">
                    <img class="Avatar Avatar--large UserAvatar-inner" width="160" height="160" src="{{ $user->avatar }}" >
                </div>


                <div class="ProfileHeader-content">
                    <div class="ProfileHeader-contentHead">
                        <h1 class="ProfileHeader-title">
                            <span class="ProfileHeader-name" style="font-size: 20px;">{{ $user->name }} - {{ $user->settings['bio'] }}</span>
                            <span class="ztext ProfileHeader-headline"></span>
                        </h1>
                    </div>
                    <div class="ProfileHeader-contentBody" style="overflow: hidden; transition: height 300ms ease-out; height: 20px;">
                        <div>
                            <div class="ProfileHeader-info">
                                <div class="ProfileHeader-infoItem">
                                    <div class="ProfileHeader-iconWrapper">
                                        <svg width="14" height="16" viewBox="0 0 12 16" class="Icon Icon--female" aria-hidden="true" style="height: 16px; width: 14px;">
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ProfileHeader-contentFooter">


                        <div class="MemberButtonGroup ProfileButtonGroup ProfileHeader-buttons">

                            @if(Auth::check() && Auth::user()->id == $user->id)
                                <a href="{{ route('user.setting') }}"><button type="button" class="btn btn-default">编辑个人资料</button></a>

                            @else
                            <user-follower-component user_id="{{ $user->id }}"></user-follower-component>

                            <send-message-component user_id="{{ $user->id }}"></send-message-component>
                            

                            @endif
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>




<div class="Profile-main">
    
    <div class="Profile-mainColumn">
        <div class="ProfileMain-header">
            <ul role="tablist" class="ProfileMain-tabs" style="padding-inline-start: 0px;-webkit-padding-start:0px">
                <li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Profile-activities">
                    <a class="Tabs-link is-active" href="/people/yi-ning-76-93/activities">动态</a>
                </li>
<!--                 <li role="tab" class="Tabs-item" aria-controls="Profile-answers"><a class="Tabs-link" href="/people/yi-ning-76-93/answers">回答<span class="Tabs-meta">0</span></a></li>
                <li role="tab" class="Tabs-item" aria-controls="Profile-asks"><a class="Tabs-link" href="/people/yi-ning-76-93/asks">提问<span class="Tabs-meta">0</span></a></li>
                <li role="tab" class="Tabs-item" aria-controls="Profile-posts"><a class="Tabs-link" href="/people/yi-ning-76-93/posts">文章<span class="Tabs-meta">0</span></a></li>
                <li role="tab" class="Tabs-item" aria-controls="Profile-columns"><a class="Tabs-link" href="/people/yi-ning-76-93/columns">专栏<span class="Tabs-meta">0</span></a></li>
                <li role="tab" class="Tabs-item" aria-controls="Profile-pins"><a meta="0" class="Tabs-link" href="/people/yi-ning-76-93/pins">想法<span class="Tabs-meta">0</span></a></li> -->
            </ul>
        </div>


        


            <div class="ListShortcut">
                <div class="List ProfileActivities" id="Profile-activities" data-zop-feedlistfather="1">
                    <div class="List-header">
                        <h4 class="List-headerText">
                            <span>我的动态</span>
                        </h4>
                        <div class="List-headerOptions"></div>
                    </div>

                    <div class="">



                    @foreach($dynamics as $k => $danamic)
                        @if($danamic->type == 2)                        
                        <!-- 关注的主题 -->                        
                        <div class="List-item">
                            <div class="List-itemMeta">
                                <div class="ActivityItem-meta">
                                    <span class="ActivityItem-metaTitle">关注了话题</span>
                                    <span>{{ formatTime($danamic->created_at) }}</span>
                                </div>
                            </div>
                            <div class="ContentItem">
                                <div class="ContentItem-main">
                                    <div class="ContentItem-image">
                                        <a class="TopicLink" href="{{ route('topic',['topic_id' => $danamic->topic_id]) }}" target="_blank">
                                            <div class="Popover">
                                                <div id="Popover5-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover5-content">
                                                    <img class="Avatar Avatar--large TopicLink-avatar" width="60" height="60" src="{{ $danamic->topic->cover }}" alt="{{ $danamic->topic->name }}">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="ContentItem-head">
                                        <h2 class="ContentItem-title">
                                            <a class="TopicLink" href="{{ route('topic',['topic_id' => $danamic->topic_id]) }}" target="_blank">
                                                <div class="Popover">
                                                    <div id="Popover6-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover6-content">{{ $danamic->topic->name }}</div>
                                                </div>
                                            </a>
                                        </h2>
                                        <div class="ContentItem-meta">
                                            <div class="ztext TopicItem-meta">{{ $danamic->topic->bio }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 关注的主题 -->
 



                        @elseif($danamic->type == 5)
                        <!-- 关注的问题 -->
                        <div class="List-item">
                            <div class="List-itemMeta">
                                <div class="ActivityItem-meta"><span class="ActivityItem-metaTitle">关注了问题</span><span>{{ formatTime($danamic->created_at) }}</span></div>
                            </div>
                            <div class="ContentItem">
                                <h2 class="ContentItem-title">
                                    <div class="QuestionItem-title">
                                        <a href="{{ route('questions.show',['id' => $danamic->userQuestion->id]) }}" target="_blank" rel="noopener noreferrer" data-za-detail-view-name="Title">{{ $danamic->userQuestion->title }}
                                        </a>
                                    </div>
                                </h2>
                            </div>
                        </div>
                        <!-- 关注的问题 -->




                        @elseif($danamic->type == 1)
                        <!-- 发布的问题 -->
                        <div class="List-item">
                            <div class="List-itemMeta">
                                <div class="ActivityItem-meta">
                                    <span class="ActivityItem-metaTitle">发布了问题</span>
                                    <span>{{ formatTime($danamic->created_at) }}</span>
                                </div>
                            </div>

                            <div class="ContentItem PinItem">
                                <div class="ContentItem-meta">
                                    <div>
                                        <div class="PinItem-author">
                                            <div class="AuthorInfo PinItem-authorInfo">
                                                <span class="UserLink AuthorInfo-avatarWrapper">
                                                    <div class="Popover">
                                                        <div id="Popover6-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover6-content">
                                                            <a class="UserLink-link" data-za-detail-view-element_name="User" target="_blank" href="{{ route('people.index',['id' => $danamic->question->user->id]) }}">
                                                                <img class="Avatar AuthorInfo-avatar" width="38" height="38" src="{{ $danamic->question->user->avatar }}" alt="刘校长">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div class="AuthorInfo-content">
                                                    <div class="AuthorInfo-head">
                                                        <span class="UserLink AuthorInfo-name">
                                                            <div class="Popover">
                                                                <div id="Popover7-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover7-content">
                                                                    <a class="UserLink-link" data-za-detail-view-element_name="User" target="_blank" href="{{ route('people.index',['id' => $danamic->question->user->id]) }}">{{ $danamic->question->user->name }}</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="AuthorInfo-detail">
                                                        <div class="AuthorInfo-badge">
                                                            <div class="ztext AuthorInfo-badgeText">
                                                                <a href="{{ route('questions.show',['id' => $danamic->question->id]) }}">{{ $danamic->question->title }}</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="RichContent">
                                    <div class="RichContent-inner">
                                        <span class="RichText ztext CopyrightRichText-richText" style="line-height: 30px;" itemprop="text">{{ $danamic->question->desc }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="RichText ztext PinItem-remainContentRichText"></div>
                                        <div class="ContentItem-time">
                                            <a target="_blank" href="">
                                                <span>发布于 {{ $danamic->question->created_at }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ContentItem-actions RichContent-actions">

                                        <div style="display: flex;">
                                                <comment-component class="margin-left-10" type="question" model="{{ $danamic->question_id }}" count="{{ $danamic->question->comments()->count() }}"></comment-component>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 发布的问题 -->





                        @elseif($danamic->type == 3)
                        <!-- 回答答案 -->
                        <div class="List-item">
                            <div class="List-itemMeta">
                                <div class="ActivityItem-meta">
                                    <span class="ActivityItem-metaTitle">回答了问题</span>
                                    <span>{{ formatTime($danamic->created_at) }}</span>
                                </div>
                            </div>
                            <div class="ContentItem AnswerItem">
                                <h2 class="ContentItem-title">
                                    <div>
                                        <a target="_blank">{{ $danamic->answer->question->title }}</a>
                                    </div>
                                </h2>
                                <div class="ContentItem-meta">
                                    <div class="AuthorInfo AnswerItem-authorInfo" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
                                        <span class="UserLink AuthorInfo-avatarWrapper">
                                            <div class="Popover">
                                                <div id="Popover117-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover117-content">
                                                    <a class="UserLink-link" data-za-detail-view-element_name="User" target="_blank" href="//www.zhihu.com/people/sun-shao-jun-73">
                                                        <img class="Avatar AuthorInfo-avatar" width="38" height="38" src="{{ $danamic->answer->user->avatar }}" alt="{{ $danamic->answer->user->name }}">
                                                    </a>
                                                </div>
                                            </div>
                                        </span>
                                        <div class="AuthorInfo-content">
                                            <div class="AuthorInfo-head">
                                                <span class="UserLink AuthorInfo-name">
                                                    <div class="Popover">
                                                        <div id="Popover118-toggle" aria-haspopup="true" aria-expanded="false" aria-owns="Popover118-content">
                                                            <a class="UserLink-link" target="_blank" href="">{{ $danamic->answer->user->name }}</a>
                                                        </div>
                                                    </div>
                                                    <a class="UserLink-badge" data-tooltip="优秀回答者" href="https://www.zhihu.com/question/48509984" target="_blank">
                                                        <span style="display: inline-flex; align-items: center;">​
                                                            <svg class="Zi Zi--BadgeGlorious" fill="currentColor" viewBox="0 0 24 24" width="18" height="18">
                                                                <g fill="none" fill-rule="evenodd">
                                                                    <path fill="#FF9500" d="M2.64 13.39c1.068.895 1.808 2.733 1.66 4.113l.022-.196c-.147 1.384.856 2.4 2.24 2.278l-.198.016c1.387-.122 3.21.655 4.083 1.734l-.125-.154c.876 1.084 2.304 1.092 3.195.027l-.127.152c.895-1.068 2.733-1.808 4.113-1.66l-.198-.022c1.386.147 2.402-.856 2.279-2.238l.017.197c-.122-1.388.655-3.212 1.734-4.084l-.154.125c1.083-.876 1.092-2.304.027-3.195l.152.127c-1.068-.895-1.808-2.732-1.66-4.113l-.022.198c.147-1.386-.856-2.4-2.24-2.279l.198-.017c-1.387.123-3.21-.654-4.083-1.733l.125.153c-.876-1.083-2.304-1.092-3.195-.027l.127-.152c-.895 1.068-2.733 1.808-4.113 1.662l.198.02c-1.386-.147-2.4.857-2.279 2.24L4.4 6.363c.122 1.387-.655 3.21-1.734 4.084l.154-.126c-1.083.878-1.092 2.304-.027 3.195l-.152-.127z"></path>
                                                                    <path fill="#FFF" d="M12.034 14.959L9.379 16.58c-.468.286-.746.09-.617-.449l.721-3.025-2.362-2.024c-.417-.357-.317-.681.236-.725l3.1-.249 1.195-2.872c.21-.507.55-.512.763 0l1.195 2.872 3.1.249c.547.043.657.365.236.725l-2.362 2.024.721 3.025c.128.534-.144.738-.617.449l-2.654-1.621z"></path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="AuthorInfo-detail">
                                                <div class="AuthorInfo-badge">

                                                        <span class="Topstory-newUserFollowItemExtraInfo">{{$danamic->answer->question->answers_count}} 回答 ·&nbsp;{{$danamic->answer->question->comment_count}} 评论 ·&nbsp;{{$danamic->answer->question->followers_count}} 关注者</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="RichContent is-collapsed">
                                    <div class="RichContent-inner">
                                        <span class="RichText ztext CopyrightRichText-richText" itemprop="text">
                                            {!! $danamic->answer->body !!}
                                        </span>
                                    </div>
                                    <div class="ContentItem-actions">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 回答答案 -->
                        @endif



                    @endforeach






                    </div>
                </div>
            </div>







    </div>


    <div class="Profile-sideColumn" data-za-module="RightSideBar">
        <div class="Card FollowshipCard">
            <div class="NumberBoard FollowshipCard-counts NumberBoard--divider">
                <a type="button" class="Button NumberBoard-item Button--plain" href="/people/yi-ning-76-93/following">
                    <div class="NumberBoard-itemInner">
                        <div class="NumberBoard-itemName">关注了</div>
                        <strong class="NumberBoard-itemValue" title="0">{{ $user->follwings_count }}</strong>
                    </div>
                </a>

                <a type="button" class="Button NumberBoard-item Button--plain" href="/people/yi-ning-76-93/followers">
                    <div class="NumberBoard-itemInner">
                        <div class="NumberBoard-itemName">关注者</div>
                        <strong class="NumberBoard-itemValue" title="2">{{ $user->follwers_count }}</strong>
                    </div>
                </a>
            </div>

        </div>

        <div class="Profile-lightList" style="background-color: #fff;">

            <a class="Profile-lightItem" href="#" style="padding: 10px;">
                <span class="Profile-lightItemName">关注的问题数</span>
                <span class="Profile-lightItemValue">{{ $user->followQuestion->count() }}</span>
            </a>

            <a class="Profile-lightItem" href="#" style="padding: 10px;">
                <span class="Profile-lightItemName">回答的问题数</span>
                <span class="Profile-lightItemValue">{{ $user->answers_count }}</span>
            </a>

        </div>


        <div class="Profile-footerOperations"></div>
    </div>
</div>







        </div>
    </div>
</div>
@endsection
