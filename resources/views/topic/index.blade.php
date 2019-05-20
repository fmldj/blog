@extends('layouts.app')

@section('meta')
<title>话题广场 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 panel">
 
                    <div class="zg-wrap zu-main clearfix " role="main">
                        <div class="zu-main-content">
                            <div class="zu-main-content-inner">

                                <div class="zm-topic-cat-page">
                                    <div class="zm-topic-cat-title">

                                    @if(Auth::check())
                                    <a href="/people/hai-shi-tian-de-dao-ying-22/topics" class="zg-link-gray zg-right">
                                        <span>已关注 {{ Auth::user()->followUserTopic()->count() }} 个话题</span>
                                    </a>
                                    @endif

                                    <h2><i class="zg-icon zg-icon-topic-square"></i>话题广场</h2>
                                    </div>

                                    <div class="zm-topic-cat-sub">
                                        <div class="zh-general-list clearfix" style="display: block;">

                                            @foreach($topics as $topic)
                                            <div class="item">
                                                <div class="blk">
                                                    <a target="_blank" href="{{ route('topic',['topic_id' => $topic->id]) }}">
                                                        <img src="{{ $topic->cover }}" alt="{{ $topic->name }}">
                                                        <strong>{{ $topic->name }}</strong>
                                                    </a>
                                                    <p style="margin-top: 20px;">{{ mb_substr($topic->bio,0,60,'utf8') }}...</p>

                                                    <topic-component class="follow meta-item zg-follow" status="{{ $topic->is_followed }}" topic_id="{{ $topic->id }}"></topic-component>

                                                </div>
                                            </div>
                                            @endforeach


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>





                    </div>

        </div>
    </div>
</div>
@endsection
