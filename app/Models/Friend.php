<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';

    protected $fillable = [
        'user_id', 'friend_user_id', 'new',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function userFriend() {
        return $this->belongsTo('App\Models\User', 'friend_user_id', 'id');
    }
}
