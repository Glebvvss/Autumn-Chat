<?php 

namespace App\Models\Traits\Scopes;

use Auth;

trait TUserScopes {

    public function scopeSearchByOccurrence($query, $usernameQccurance)
    {
        return $query->select('username')
                     ->where('username', 'LIKE', $usernameQccurance . '%')
                     ->where('username', '<>', Auth::user()->username);
    }

}