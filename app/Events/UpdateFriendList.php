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

    public $idUser;
    public $type;

    public function __construct($idUser, $type) {
        $this->idUser = $idUser;
        $this->type = $type;
    }

    public function broadcastOn() {
        return ['friend'];
    }

    public function broadcastAs() {
        return 'UPDATE_FRIEND_LIST';
    }

}
