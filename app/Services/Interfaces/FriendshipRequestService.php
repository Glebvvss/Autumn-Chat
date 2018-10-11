<?php 

namespace App\Services\Interfaces; 

interface FriendshipRequestService
{
    public function sendTo( string $username );

    public function confirmFrom( int $id );

    public function cancelSendedTo( int $id );

    public function cancelRecivedFrom( int $id );
}