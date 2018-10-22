<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnreadMessageLink extends Model
{
    protected $table = 'read_status_messages';

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