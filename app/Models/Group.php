<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Scopes\TGroupScopes;

class Group extends Model
{
    use TGroupScopes;

    protected $table = 'groups';

    public function messages() {
    	return $this->hasMany('App\Models\Message');
    }

    public function users() {
    	return $this->belongsToMany('App\Models\User');
    }
}
  