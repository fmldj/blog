<?php

namespace App\Listeners;

use App\Model\Topic;
use App\Model\Dynamic;
use App\Events\TopicEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TopicEventListener
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
     * @param  TopicEvent  $event
     * @return void
     */
    public function handle(TopicEvent $event)
    {
            if(count($event->res['detached']) > 0){
                    Topic::where('id',$event->topic_id)->decrement('followers_count');//主题关注数-1

                    // 关于主题的动态删除
                    Dynamic::where([            
                    'user_id' => authApiUser()->id,
                    'topic_id' => $event->topic_id,
                    'type' => 2,])->delete();

                    return ['status' => false];

            }else{
                    // 关于主题的动态添加
                    Dynamic::create([
                            'user_id' => authApiUser()->id,
                            'topic_id' => $event->topic_id,
                            'type' =>2,
                    ]);

                    Topic::where('id',$event->topic_id)->increment('followers_count');//主题关注数+1
                    return ['status' => true];
            }        
    }
}
