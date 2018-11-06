<?php 

namespace App\Services\Interfaces; 

interface IFriendshipRequestService
{
    public function sendTo( string $username ) : string;

    public function confirmFrom( int $id ) : string;

    public function cancelRecivedFrom( int $id ) : string;

    public function cancelSendedTo( int $id ) : string;

    public function countNewRecived() : int;

    public function readByRecipient() : void;
}