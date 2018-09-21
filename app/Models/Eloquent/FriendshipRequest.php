<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class FriendshipRequest extends Model
{
    protected $table = 'friendship_requests';

    public function userSender() {
        return $this->belongsTo('App\Models\Eloquent\User', 'sender_id', 'id');
    }

    public function userRecipient() {
        return $this->belongsTo('App\Models\Eloquent\User', 'recipient_id', 'id');
    }
}
