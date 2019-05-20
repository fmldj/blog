<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserFollowerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $following;
    private $followed;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $following,User $followed)
    {
        $this->following = $following;
        $this->followed = $followed;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('myFollower-'.$this->followed->id);
    }

    public function broadcastWith()
    {
        return [
            'username' => $this->following->name,
        ];
    }
}
