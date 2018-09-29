<?php

namespace App\ORM\Eloquent;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';

    public function messages() {
    	return $this->hasMany('App\ORM\Eloquent\Message');
    }

    public function messagesMeta() {
    	return $this->hasMany('App\ORM\Eloquent\MessageMeta');
    }

    public function groups() {
    	return $this->belongsToMany('App\ORM\Eloquent\Group');
    }

    public function friends() {
        return $this->hasMany('App\ORM\Eloquent\Friend');
    }

    public function friendshopRequestSenders() {
        return $this->hasMany('App\ORM\Eloquent\FriendshipRequest', 'id', 'sender_id');
    }

    public function friendshopRequestRecipients() {
        return $this->hasMany('App\ORM\Eloquent\FriendshipRequest', 'id', 'recipient_id');
    }

}
