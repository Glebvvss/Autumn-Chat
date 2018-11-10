<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendHistoryPostsToClients implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $historyPosts;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( array $historyPosts )
    {
        $this->historyPosts = $historyPosts;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['none'];
    }

    public function broadcastAs() {
        return 'SEND_HISTORY_POSTS_TO_CLIENTS';
    }
}