<?php

namespace App\ORM\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public function user() {
    	return $this->belongsTo('App\ORM\Eloquent\User');
    }

	public function group() {
    	return $this->belongsTo('App\ORM\Eloquent\Group');
    }    
}
