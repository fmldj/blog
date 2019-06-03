<?php

namespace App\Listeners;

use App\Model\User;
use App\Model\Topic;
// use App\Model\Answer;
use App\Model\Dynamic;
use App\Events\QuestionsDelEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class QuestionsDelEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(QuestionsDelEvent $event)
    {

        $event->question->comments->map(function($value){
            User::find($value->user_id)->decrement('comments_count');//用户表中的评论数减1
        });

        $event->question->answer->map(function($value){
            User::find($value->user_id)->decrement('answers_count');//用户表中的答案数减1
            $value->vote()->detach();//删除用户所点赞的答案
        });


        $event->question->followed()->detach();//删除用户所关注的问题

        $event->question->comments()->delete();//删除问题下的所有的评论

        $event->question->answer()->delete();//删除问题下的所有的答案

        
        $event->question->user()->decrement('questions_count');//成功之后用户的发表问题数-1

        $event->question->topics->map(function($name){
            if($name->id){
                Topic::find($name->id)->decrement('questions_count');//将主题表中对应的问题数-1
            }
            
        });

        $event->question->topics()->detach();//删除在question_topics表中question_id=$id的数据(问题与主题的关系)
       
        Dynamic::where('question_id',$event->question->id)->delete();// 删除当前所属的用户动态
        

    }
}
