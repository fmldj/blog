@extends('layouts.app')

@section('meta')
<title>{{$question->title}} - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">编辑问题</div>
                        <div class="panel-body">
                            <form action="{{ route('questions.update',['id' => $question->id]) }}" method="post">

                                {!! csrf_field() !!}
                                <div class="form-group {{ $errors->has('title')?'has-error':'' }}">
                                    <label for="title">标题</label>
                                    <input type="text" value="{{ $question->title }}" name="title" class="form-control" placeholder="标题" id="title">
                                 @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                 @endif                                    
                                </div>

                                <div class="form-group {{ $errors->has('desc') ? 'has-error' : '' }}">
                                    <label for="desc">描述</label>
                                    <textarea class="form-control" name="desc">{{ $question->desc }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
                                @endif

                                </div>

                                <div class="form-group {{ $errors->has('body')?'has-error':'' }}">
                                 <label for="title">内容</label>
                                 <script id="container" style="height:200px" name="body" type="text/plain">{!!$question->body!!}</script>
                                 @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                 @endif                                    

                                </div>
   
                                <div class="form-group">
                                    <label for="title">所属话题</label>
                                    <select style="width: 100%" class="js-example-basic-multiple" name="topics[]" multiple="multiple">
                                        @foreach($question->topics as $topic)
                                                <option value="{{ $topic->id }}" selected="selected">{{ $topic->name }}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <button class="btn btn-success pull-right" type="submit">编辑问题</button>
                            </form>
                        </div>                 

                
            </div>
        </div>
    </div>
</div>


@section('scripts')
@include('vendor.ueditor.assets')
<!-- 实例化编辑器 -->
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
$(function(){

function formatTopic (topic) {

    return "<div class='select2-result-repository clearfix'>" +

        "<div class='select2-result-repository__meta'>" +

        "<div class='select2-result-repository__title'>" +

        topic.name ? topic.name : "Laravel"   +

        "</div></div></div>";

}


function formatTopicSelection (topic) {

    return topic.name || topic.text;

}


$(".js-example-basic-multiple").select2({

    tags: true,

    placeholder: '选择相关话题',

    minimumInputLength: 2,

    ajax: {

        url: '/api/topics',

        dataType: 'json',

        delay: 250,

        data: function (params) {

            return {

                q: params.term

            };

        },

        processResults: function (data, params) {

            return {

                results: data

            };

        },

        cache: true

    },

    templateResult: formatTopic,

    templateSelection: formatTopicSelection,

    escapeMarkup: function (markup) { return markup; }

});

})




</script>


@stop


<!-- 编辑器容器 -->

@endsection