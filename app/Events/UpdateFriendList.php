<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateFriendList implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $type;

    public function __construct($userId, $type) {
        $this->userId = $userId;
        $this->type = $type;
    }

    public function broadcastOn() {
        return ['none'];
    }

    public function broadcastAs() {
        return 'UPDATE_FRIEND_LIST';
    }

}
