<?php

namespace App\Events;

use App\Question;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 发表文章后提醒打开本网站的每一个用户
 *
 * @package default
 * @author 
 **/
class QuestionSendEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $question;
    public $topic_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Question $question,$topic = null)
    {
        $this->question = $question;
        $this->topic_id = $topic;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('question-send');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->question->id,
            'title' => $this->question->title,
            'from_user' => $this->question->user->name
        ];
    }


    
}
