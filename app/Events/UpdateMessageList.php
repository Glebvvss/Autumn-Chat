<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateMessageList implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idGroup;

    public function __construct(int $idGroup) {
        $this->idGroup = $idGroup;
    }

    public function broadcastOn() {
        return ['friend'];
    }

    public function broadcastAs() {
        return 'UPDATE_MESSAGE_LIST';
    }

}