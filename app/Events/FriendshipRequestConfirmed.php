<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FriendshipRequestConfirmed implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idFriend;
    public $updatedFriendlist;

    public function __construct($idFriend, $updatedFriendlist) {
        $this->idFriend = $idFriend;
        $this->updatedFriendlist = $updatedFriendlist;
    }

    public function broadcastOn() {
        return ['friend'];
    }

}
