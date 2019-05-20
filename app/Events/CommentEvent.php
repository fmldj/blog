<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $commentable_id;
    public $parent_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data, $commentable_id, $parent_id = 0)
    {
        $this->data = $data;
        $this->parent_id = $parent_id;
        $this->commentable_id = $commentable_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
