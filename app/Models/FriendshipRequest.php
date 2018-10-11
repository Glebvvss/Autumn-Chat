<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Scopes\TFriendshipRequestScopes;

class FriendshipRequest extends Model
{
    use TFriendshipRequestScopes;

    protected $table = 'friendship_requests';

    public function userSender() {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function userRecipient() {
        return $this->belongsTo('App\Models\User', 'recipient_id', 'id');
    }

}
