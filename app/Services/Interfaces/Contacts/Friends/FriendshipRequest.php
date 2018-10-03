<?php 

namespace App\Services\Interfaces\Contacts\Friends; 

interface FriendshipRequest
{
    public function getSendedAll();

    public function getRecivedAll();

    public function sendTo( string $username );

    public function confirmFrom( int $id );

    public function cancelSendedTo( int $id );

    public function cancelRecivedFrom( int $id );
}