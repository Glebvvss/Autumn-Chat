<?php 

namespace App\Services\Interfaces;

interface SearchUserService
{
    public function byOccurrence( string $usernameQccurance );
}