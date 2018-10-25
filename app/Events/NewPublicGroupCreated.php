<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPublicGroupCreated implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $memberIdList;

    public function __construct($memberIdList) {
        $this->memberIdList = $memberIdList;
    }

    public function broadcastOn() {
        return ['friend'];
    }

    public function broadcastAs() {
        return 'NEW_PUBLIC_GROUP_CREATED';
    }

}
