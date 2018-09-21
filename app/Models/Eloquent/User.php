<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public function messages() {
    	return $this->hasMany('App\Models\Eloquent\Message');
    }

    public function messagesMeta() {
    	return $this->hasMany('App\Models\Eloquent\MessageMeta');
    }

    public function groups() {
    	return $this->belongsToMany('App\Models\Eloquent\Group');
    }

    public function friends() {
        return $this->hasMany('App\Models\Eloquent\Friend');
    }
/*
    public function friendsByFriends() {
        return $this->hasMany('App\Models\Eloquent\Friend', 'id', 'friend_user_id');
    }

    public function friends() {
        return $this->hasMany('App\Models\Eloquent\Friend');
    }

    public function friendshopRequestSenders() {
        return $this->hasMany('App\Model\Eloquent\FriendshipRequest', 'id', 'sender_id');
    }

    public function friendshopRequestRecipients() {
        return $this->hasMany('App\Model\Eloquent\FriendshipRequest', 'id', 'recipient_id');
    }
*/
}
