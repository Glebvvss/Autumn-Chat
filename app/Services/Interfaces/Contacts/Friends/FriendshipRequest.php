<?php 

namespace App\Services\Interfaces\Contacts\Friends; 

interface FriendshipRequest
{
    public function getSendedAll();

    public function getRecivedAll();

    public function sendTo( string $username );

    public function confirmFrom( string $username );

    public function cancelSendedTo( string $username );

    public function cancelRecivedFrom( string $username );
}