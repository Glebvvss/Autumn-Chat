<?php 

namespace App\Services\Interfaces\Search;

interface SearchUser
{
    public function byOccurrence( string $usernameQccurance );
}