<?php

namespace App\Services\Realizations;

use Auth;
use App\Eloquent\User;
use App\Services\Interfaces\SearchUserService;

class SearchUser implements SearchUserService
{

    public function byOccurrence( string $usernameQccurance ) : array 
    {
        $matchUsernames = User::select('username')
            ->where('username', 'LIKE', $usernameQccurance . '%')
            ->where('username', '<>', Auth::user()->username)
            ->get()
            ->toArray();

        return $matchUsernames;
    }

}