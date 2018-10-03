<?php

namespace App\Services\Realizations\Search;

use Auth;
use App\Eloquent\User;
use App\Services\Interfaces\Search\SearchUser as SearchUserInterface;

class SearchUser implements SearchUserInterface
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