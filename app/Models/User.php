<?php

namespace App\Models;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\Scopes\TUserScopes;

class User extends Authenticatable {

    use Notifiable, TUserScopes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';

    public function messages() {
    	return $this->hasMany('App\Models\Message');
    }

    public function messagesMeta() {
    	return $this->hasMany('App\Models\MessageMeta');
    }

    public function groups() {
    	return $this->belongsToMany('App\Models\Group');
    }

    public function friendshopRequestSenders() {
        return $this->hasMany('App\Models\FriendshipRequest', 'id', 'sender_id');
    }

    public function friendshopRequestRecipients() {
        return $this->hasMany('App\Models\FriendshipRequest', 'id', 'recipient_id');
    }

    public function friends() {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_user_id');
    }

}
