<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateMembersOfPublicGroup implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $groupId;
    public $newMemberIdList;

    public function __construct($groupId, $newMemberIdList = null) {
        $this->groupId = $groupId;
        $this->newMemberIdList = $newMemberIdList;
    }

    public function broadcastOn() {
        return ['none'];
    }

    public function broadcastAs() {
        return 'UPDATE_MEMBERS_OF_PUBLIC_GROUP';
    }

}
