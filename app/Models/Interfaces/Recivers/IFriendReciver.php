<?php 

namespace App\Models\Interfaces\Recivers;

interface IFriendReciver 
{
    public function getById( int $id );

    public function getByUsername( string $username );

    public function getByEmail( string $email );

    public function getAll();
}