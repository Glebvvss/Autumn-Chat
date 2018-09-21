<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';

    public function user() {
        return $this->belongsTo('App\Models\Eloquent\User', 'user_id', 'id');
    }

    public function userFriend() {
        return $this->belongsTo('App\Models\Eloquent\User', 'friend_user_id', 'id');
    }
}
