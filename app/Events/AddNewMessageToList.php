<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddNewMessageToList implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $groupId;
    public $message;

    public function __construct(int $groupId, $message) {
        $this->groupId = $groupId;
        $this->message = $message;
    }

    public function broadcastOn() {
        return ['none'];
    }

    public function broadcastAs() {
        return 'ADD_NEW_MESSAGE_TO_LIST';
    }

}