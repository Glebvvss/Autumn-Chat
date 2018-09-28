<?php

namespace App\Models\Contacts;

use Auth;
use App\Models\Eloquent\User;
use Illuminate\Database\Eloquent\Collection;

class UserSearcher {

    public function searchByOccurrence( string $usernameQccurance ) : Collection {
        $matchUsernames = User::select('username')
            ->where('username', 'LIKE', $usernameQccurance . '%')
            ->where('username', '<>', Auth::user()->username)
            ->get();

        return $matchUsernames;
    }

}