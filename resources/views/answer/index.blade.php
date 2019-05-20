@extends('layouts.app')

@section('meta')
<title>写回答 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="zg-section zm-tag-editor-command-buttons-wrap">
                     <input class="zg-form-text-input zg-mr15 label-input-label" type="text" placeholder="添加擅长话题" aria-label="添加擅长话题" title="添加擅长话题" >
                     <input type="hidden" name="hidden-topic-name">
                     <input type="hidden" name="hidden-topic-id">

                    <a href="" class="topic"></a>

                    <div class="ac-renderer" role="listbox" id=":7" style="user-select: none; display:none;" aria-expanded="false">




                    </div>                               

                    </div>
                </div>

                <div class="panel-body">

                            <div class="zh-general-list clearfix">

<!--                                 <div class="feed-item feed-item-hook question-item">
                                        <link itemprop="url" href="/question/292946523">
                                        <meta itemprop="question-url-token" content="292946523">
                                        <div class="subtopic">来自：<a data-hovercard="t$t$19551326" target="_blank" href="/topic/20003793">微软小冰</a></div>
                                        <h5 class="question-item-title">
                                        <a target="_blank" class="question_link" href="/question/292946523">小冰为什么有时前言不搭后语？</a>
                                        </h5>
                                        <div class="question-item-meta">
                                        <a class="zg-link-gray-normal meta-item" target="_blank" href="/question/292946523">1 个回答</a>
                                        <span class="zg-bull">•</span>
                                        <a class="zg-link-gray-normal meta-item" href="/question/292946523/followers">2 人关注</a>
                                        <a href="#" class="ignore zu-autohide" name="dislike" data-tooltip="s$b$不感兴趣"></a>
                                        </div>             
                                </div>   -->







                            </div>



                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript">
    $(function(){


        $('input[type=text]').keyup(function(){
            var name = this.value;
            $.ajax({
                type:'GET',
                data:{q:name},
                dataType:'JSON',
                url:'/api/topics',
                success:function(res){
                    $('.ac-renderer').show();
                    var html = "";

                    for(i=0;i<res.length;i++){
                            html +='<div class="ac-row topic-id" topic-id="'+res[i].id+'" topic-name="'+res[i].name+'" id=":37" role="option" style="user-select: none;">';
                            html +='<img width="30px" class="zm-item-img-avatar zg-left" src="'+res[i].cover+'" style="user-select: none;">';
                            html +='<span class="zu-autocomplete-row-name" title="'+res[i].name+'" style="user-select: none;"><bclass="ac-highlighted" style="user-select: none;">'+res[i].name+'</b></span>';
                            html +='<span class="zg-gray-normal zu-autocomplete-row-description" style="user-select: none;">&nbsp;</span>';
                            html += '</div>';
                    }

                    $('.ac-renderer').html(html);
                }
            });
        });



        $('.row').on('mousemove','.ac-row',function(){
            var name = $(this).attr('topic-name');
            var id = $(this).attr('topic-id');
            $('input[name=hidden-topic-name]').val(name);
            $('input[name=hidden-topic-id]').val(id);
        });




        $('input[type=text]').blur(function(){
                $('input[type=text]').val('');
                $('.topic').text($('input[name=hidden-topic-name]').val());
                $('.ac-renderer').hide();
                var topic_id = $('input[name=hidden-topic-id]').val();
                        if(topic_id){
                               setTimeout(getTopicQuetion(topic_id),1000);                           
                        }
        });



        function getTopicQuetion(topic_id)
        {
            $.ajax({
                type:'GET',
                url:"/topic/"+topic_id+"/question",
                dataType:'json',
                success:function(res){
                    console.log(res);
                    var html = '';
                    for(i=0;i<res.data.length;i++){
                                html +='<div class="feed-item feed-item-hook question-item">';
                                html +='        <link itemprop="url" href="/question/292946523">';
                                html +='        <meta itemprop="question-url-token" content="292946523">';
                                html +='        <div class="subtopic">来自：<a data-hovercard="t$t$19551326" target="_blank" href="#">'+res.data[i]['name']+'</a></div>';
                                html +='        <h5 class="question-item-title">';
                                html +='        <a target="_blank" class="question_link" href="/questions/'+res.data[i]['id']+'">'+res.data[i]['title']+'</a>';
                                html +='        </h5>';
                                html +='        <div class="question-item-meta">';
                                html +='        <a class="zg-link-gray-normal meta-item" target="_blank" href="/question/292946523">'+res.data[i]['answer']+' 个回答</a>';
                                html +='        <span class="zg-bull">•</span>';
                                html +='        <a class="zg-link-gray-normal meta-item" href="/question/292946523/followers">'+res.data[i]['followers_count']+' 人关注</a>';
                                html +='        <a href="#" class="ignore zu-autohide" name="dislike" data-tooltip="s$b$不感兴趣"></a>';
                                html +='        </div>';             
                                html +='</div>';
                    }

                    $('.zh-general-list').html(html);
                }
            });
        }



    })
</script>
@stop
@endsection
