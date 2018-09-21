<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public function user() {
    	return $this->belongsTo('App\Models\Eloquent\User');
    }

	public function group() {
    	return $this->belongsTo('App\Models\Eloquent\Group');
    }    
}
