@extends('layouts.app')

@section('meta')
<title>搜索 ‘{{ $q }}’ - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')

<div class="Topstory-container">
    <div class="Topstory-mainColumn">

        <div id="TopstoryContent" class="Topstory-content">

            <div class="panel panel-default">
              <div class="panel-body">
                关于 “<span style="color:red">{{ $q }}</span>” 的搜索结果，@if(!empty($questions))共 {{ $questions['hits']['total']['value'] }} 条，耗时 {{ round($questions['took']/60,2) }} 秒@endif
              </div>
            </div>

            @if(empty($questions))

                <div class="Dj-self-question padding-top-30">没有想要的内容 ？Σ(⊙▽⊙"a</div>

            @else
                @if($questions['hits']['hits'])
                        @foreach($questions['hits']['hits'] as $key => $question)
                                <div class="color-white ListShortcut" style="margin-bottom: 20px">
                                    <div class="col-md-offset-1 padding-top-30 padding-bottom-30">
                                            <div class="media padding-bottom-20">
                                                <div class="media-left">
                                                    <a href="{{ route('people.index',['id' => $question['_source']['user_id']]) }}">
                                                        <img class="border-radis-img" width="36" src="{{ $question['_source']['avatar'] }}" alt="{{ $question['_source']['user_name'] }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <a href="{{ route('questions.show',['id' => $question['_id'] ]) }}">{{ $question['_source']['question_title'] }}</a>
                                                    </h4>
                                                    <div class="coverContent">

                                                        <div class="question-content" style="height: 160px;">
                                                            <span>{!! $question['highlight']['question_body'][0] !!}...</span>
                                                        </div>    
                                                 

                                                    </div>

                                                    <comment-component class="margin-left-10" type="question" model="{{ $question['_id'] }}" count="{{ $question['_source']['comments'] }}"></comment-component>
                                                </div>

                                            </div>
                                    </div>
                                </div>

                        @endforeach
                @else
                        <div class="Dj-self-question padding-top-30">抱歉没有收到你需要的内容喔 ┭┮﹏┭┮！ <a class="font-size-13" href="{{ route('questions.create') }}">赶紧提问吧</a></div>

                @endif
            @endif

        </div>
    </div>


    <div class="GlobalSideBar">
        <div>
            <div class="Sticky">
                <div class="Card">
                    <div class="GlobalWrite">
                        <div class="GlobalWrite-nav">
                            <a class="GlobalWrite-navItem" href="{{ route('answer.index') }}" target="_blank" rel="noopener noreferrer" title="回答"><svg class="Zi Zi--Paper GlobalWrite-navIcon" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M9.273 5.63c-1.103 0-1.439.064-1.782.243a1.348 1.348 0 0 0-.576.564c-.183.336-.248.664-.248 1.743v6.64c0 1.079.065 1.407.248 1.743.135.247.323.431.576.564.343.18.68.243 1.782.243h5.454c1.103 0 1.439-.064 1.782-.243.253-.133.44-.317.576-.564.183-.336.248-.664.248-1.743V8.18c0-1.079-.065-1.407-.248-1.743a1.348 1.348 0 0 0-.576-.564c-.343-.18-.68-.243-1.782-.243H9.273zm0-1.63h5.454c1.486 0 2.025.151 2.568.436.543.284.97.7 1.26 1.232.29.532.445 1.059.445 2.512v6.64c0 1.453-.155 1.98-.445 2.512-.29.531-.717.948-1.26 1.232-.543.285-1.082.436-2.568.436H9.273c-1.486 0-2.025-.151-2.568-.436a2.997 2.997 0 0 1-1.26-1.232C5.155 16.8 5 16.273 5 14.82V8.18c0-1.453.155-1.98.445-2.512.29-.531.717-.948 1.26-1.232C7.248 4.15 7.787 4 9.273 4zM8.5 8.076v1.467h7V8.076h-7zm0 2.609v1.467h7v-1.467h-7zm0 2.608v1.468h4.667v-1.468H8.5z"></path></svg><div class="GlobalWrite-navTitle">写回答</div></a>

                            <a class="GlobalWrite-navItem" href="{{ route('questions.create') }}" target="_blank" title="提问题"><svg class="Zi Zi--WriteArticle GlobalWrite-navIcon" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M15.764 7.279l-3.76 3.765c-.428.43-.555.567-.667.713a1.666 1.666 0 0 0-.208.348c-.076.167-.137.344-.314.926l-.073.243.242-.074c.58-.177.757-.238.925-.314.13-.06.232-.12.347-.209.146-.112.282-.239.712-.668l3.759-3.766-.963-.964zm.963-.965l.963.965.685-.686c.167-.168.227-.263.253-.349a.187.187 0 0 0 0-.12c-.026-.086-.086-.18-.253-.348l-.148-.148c-.167-.167-.262-.228-.348-.254a.187.187 0 0 0-.12 0c-.085.026-.18.087-.347.254l-.685.686zm.87 5.471l1.702-1.705v5.549c0 1.52-.158 2.07-.455 2.626a3.096 3.096 0 0 1-1.287 1.29c-.555.297-1.105.455-2.623.455h-5.57c-1.517 0-2.068-.158-2.622-.455a3.096 3.096 0 0 1-1.287-1.29C5.158 17.7 5 17.15 5 15.63v-5.58c0-1.52.158-2.071.455-2.627a3.096 3.096 0 0 1 1.287-1.289c.554-.297 1.105-.455 2.622-.455h3.497l-1.702 1.705H9.364c-1.126 0-1.47.066-1.82.254-.258.138-.45.33-.588.59-.188.35-.254.694-.254 1.822v5.58c0 1.128.066 1.472.254 1.822.138.259.33.452.588.59.35.188.694.254 1.82.254h5.57c1.127 0 1.47-.066 1.82-.254.258-.138.45-.331.589-.59.187-.35.253-.694.253-1.822v-3.844zm1.593-7.121l.148.147c.33.33.502.616.594.918.09.301.09.61 0 .911-.092.302-.265.587-.594.917l-5.408 5.416c-.486.487-.648.635-.845.786a3.02 3.02 0 0 1-.614.37c-.226.102-.433.176-1.091.376l-.852.26a1.021 1.021 0 0 1-1.275-1.277l.26-.854c.2-.659.273-.866.375-1.092.103-.227.218-.418.369-.616.15-.197.299-.36.785-.846l5.407-5.416c.33-.33.614-.504.915-.595.301-.092.61-.092.91 0 .301.09.586.264.916.595z"></path></svg><div class="GlobalWrite-navTitle">提问题</div></a>


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