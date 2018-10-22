<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnreadMessageLink extends Model
{
    protected $table = 'unread_message_links';

    public function message() 
    {
        return $this->belongsTo('App\Models\Message');
    }

    public function group() 
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }
}
