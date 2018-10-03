<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function messages() {
    	return $this->hasMany('App\Eloquent\Message');
    }

    public function users() {
    	return $this->belongsToMany('App\Eloquent\User')
    }
}
