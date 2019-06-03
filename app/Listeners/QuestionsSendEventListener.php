<?php

namespace App\Listeners;

use Auth;
use App\Model\Dynamic;
use App\Events\QuestionSendEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionsSendEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(QuestionSendEvent $event)
    {
        $this->createQuestionDynamic($event);
        $event->question->user()->increment('questions_count');//成功之后用户的发表问题数+1
        $event->question->topics()->attach($event->topic_id);  //进行问题表与主题表的绑定数据
    }


    private function createQuestionDynamic($event)
    {

            Dynamic::create([
                    'user_id' => Auth::id(),
                    'question_id' => $event->question->id,
                    'type' => 1,
            ]);

    }
}
