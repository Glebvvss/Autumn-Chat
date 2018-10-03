<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';

    protected $fillable = [
        'user_id', 'friend_user_id', 'new',
    ];

    public function user() {
        return $this->belongsTo('App\Eloquent\User', 'user_id', 'id');
    }

    public function userFriend() {
        return $this->belongsTo('App\Eloquent\User', 'friend_user_id', 'id');
    }
}