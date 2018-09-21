<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function messages() {
    	return $this->hasMany('App\Models\Eloquent\Message');
    }

    public function users() {
    	return $this->belongsToMany('App\Models\Eloquent\User')
    }
}
