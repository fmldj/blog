<?php

namespace App\Listeners;

use Auth;
use App\Dynamic;
use App\Events\AnswerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerEventListener
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
     * @param  AnswerEvent  $event
     * @return void
     */
    public function handle(AnswerEvent $event)
    {
        $event->answer->user()->increment('answers_count');//用户的回答数+1
        $event->answer->question()->increment('answers_count');//提问表的答案数+1

        // 动态添加
        Dynamic::create([
                'user_id' => Auth::id(),
                'answer_id' => $event->answer->id,
                'type' =>3,
        ]);

    }
}
