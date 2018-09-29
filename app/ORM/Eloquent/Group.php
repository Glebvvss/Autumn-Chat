<?php

namespace App\ORM\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function messages() {
    	return $this->hasMany('App\ORM\Eloquent\Message');
    }

    public function users() {
    	return $this->belongsToMany('App\ORM\Eloquent\User')
    }
}
