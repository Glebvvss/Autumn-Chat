<?php

namespace App\Services\Realizations\EloquentBased\Search;

use Auth;
use App\ORM\Eloquent\User;
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