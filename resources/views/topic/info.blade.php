@extends('layouts.app')

@section('meta')
<title>{{ $topic->name }} - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="{{ $topic->name }},Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery,{{ $topic->name }}">
@stop

@section('content')
<div class="container">
    <div class="ContentLayout">
            <div class="ContentLayout-mainColumn">
                    <div class="Card">         
                        <div class="TopicCard">
                            <div class="ContentItem TopicCard-content">
                                <div class="ContentItem-main">
                                    <div class="ContentItem-image">
                                        <img class="ImageAlias TopicCard-image" alt="{{ $topic->name }}" src="{{ $topic->cover }}">
                                    </div>
                                    <div class="ContentItem-head">
                                        <h2 class="ContentItem-title">
                                            <div class="TopicCard-title">
                                                <h1 class="TopicCard-titleText">{{ $topic->name }}</h1>
                                            </div>
                                        </h2>
                                        <div class="ContentItem-meta">
                                            <div class="TopicCard-description">
                                                <div class="TopicCard-ztext">
                                                    {!! $topic->bio !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="TopicCard-actions">
                                <div class="TopicActions">
                                        <topic-component class="follow meta-item zg-follow" status="{{ $count }}" topic_id="{{ $topic->id }}"></topic-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" color-white">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-1 padding-top-30 padding-bottom-30">
                                        @foreach($topic->questions as $question)
                                            <div class="media padding-bottom-20">
                                                <div class="media-left">
                                                    <a href="{{ route('people.index',['id' => $question->user->id]) }}">
                                                        <img class="border-radis-img" width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <a href="{{ route('questions.show',['id' =>$question->id])}}">{{ $question->title }}</a>
                                                    </h4>
                                                    <p>
                                                        {!! $question->body !!}
                                                    </p>
                                                    @if(Auth::check() && Auth::user()->id !== $question->user->id || !Auth::check()  )  
                                                        <question-component question="{{ $question->id }}" followers_count="{{ $question->followers_count }}"></question-component>
                                                    @endif
                                                    <button type="button" class="btn btn-default btn-sm margin-left-10">
                                                            <span class="glyphicon glyphicon-user"></span> {{ $question->user->name }}
                                                    </button>

                                                    <comment-component class="margin-left-10" type="question" model="{{ $question->id }}" count="{{ $question->comments()->count() }}"></comment-component>

                                                </div>

                                            </div>
                                        @endforeach
                            </div>
                        </div>
                    </div>

            </div>


            <!-- 右边 -->
            <div class="ContentLayout-sideColumn">

                    <div class="Card">
                        <div class="NumberBoard NumberBoard--divider">
                            <button type="button" class="Button NumberBoard-item TopicNumberBoard-item">
                                <div class="NumberBoard-itemInner">
                                    <div class="NumberBoard-itemName">关注者</div>
                                    <strong class="NumberBoard-itemValue">{{ $topic->followTopicUser()->count() }}</strong>
                                </div>
                            </button>
                            <a class="NumberBoard-item TopicNumberBoard-item" href="">
                                <div class="NumberBoard-itemInner">
                                    <div class="NumberBoard-itemName">问题数</div>
                                    <strong class="NumberBoard-itemValue" title="634065">{{ $topic->questions()->count() }}</strong>
                                </div>
                            </a>
                        </div>
                    </div>















            </div>



    </div>
</div>
@endsection
