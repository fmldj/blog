<?php

namespace App\Listeners;

use Auth;
use App\Answer;
use App\Dynamic;
use App\Comment;
use App\Question;
use App\Events\CommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentEventListener
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
     * @param  CommentEvent  $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {

        // 动态添加
        Dynamic::create([
                'user_id' => Auth::guard('api')->user()->id,
                'comments_id' => $event->data['comment']->id,
                'type' => 4,
        ]);

        // 问题的评论数+1
        if($event->data['model'] == 'App\Question'){
                Question::find($event->commentable_id)->increment('comment_count');
        }else{
                Question::find(Answer::find($event->commentable_id)->question_id)->increment('comment_count');
        }
        $event->data['comment']->user()->increment('comments_count');//用户的评论数+1

        // 如果的对用户信息的评论则记录父id
        if($event->parent_id !== 0){
                $parent_name = Comment::find($event->data['comment']->parent_id)->user->name;
                $comments = $event->data['comment']->with('user')->where('id',$event->data['comment']->id)->first();
                return compact('parent_name','comments');

        }

        // return ['data'=>$event];
    }
}
