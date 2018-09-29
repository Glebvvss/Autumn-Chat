<?php

namespace App\Services\Realizations\EloquentBased\Contacts\Friends;

use Auth;
use App\ORM\Eloquent\User;
use App\ORM\Eloquent\Friend;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Eloquent\FriendshipRequest as FriendRequestTable;
use App\Services\Interfaces\Contacts\Friends\FriendshipRequest as FriendshipRequestInterface;

class FriendshipRequest implements FriendshipRequestInterface
{

    public function getSendedAll() : array 
    {
        $friendshipRequests = FriendRequestTable::with(['userSender' => function($query) 
        {
            $query->select('id', 'username');
        }
        ])->select('id', 'sender_id', 'recipient_id')
          ->where('sender_id', '=', Auth::user()->id)
          ->get()
          ->toArray();

        return $friendshipRequests;
    }

    public function getRecivedAll() : array
    {
        $friendshipRequests = FriendRequestTable::with(['userSender' => function($query) 
        {
            $query->select('id', 'username');
        }
        ])->select('id', 'sender_id', 'recipient_id')
          ->where('recipient_id', '=', Auth::user()->id)
          ->get()
          ->toArray();

        return $friendshipRequests;
    }

    public function sendTo( string $username ) : string 
    {
        $recipient = $this->getUserByUsername($username);
        if ( $recipient === null ) {
            return 'This user in not exists.';
        }
        if ( $this->checkAreYouRecipient($recipient) ) {
            return 'You can`t send requests to youself.';
        }
        if ( $this->checkRecipientIsAlreadyYouFriend($recipient) === true ) {
            return 'This user is already your friend.';
        }
        if ( $this->checkWasThisRequestSentEarlier($recipient) === true ) {
            return 'This request already has been sent.';
        }
        if ( $this->checkRequestWasReceivedFromThisUser($recipient) === true ) {
            return 'Already You have request from this user.';
        }
        $this->storeRequestIntoDatabase($recipient);
        return 'Request has been sent.';
    }

    public function confirmFrom( string $username ) : string 
    {
        $sender = User::where('username', '=', $username)->first();

        if ( $sender === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestBySender( $sender );
        if ( !$request ) {
            return 'Request in not exists.';
        }

        $this->buildFriendshipsContact($request, $userSender);
        return 'Friend added!';
    }
    
    public function cancelRecivedFrom( string $username ) : string 
    {
        $sender = User::where('username', '=', $username)->first();

        if ( $sender === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestBySender($sender);
        if ( !$request ) {
            return 'Request in not valid.';
        }
        
        $this->dropRequestFromBb($request);
        return 'Friend request canceled.';
    }

    public function cancelSendedTo( string $username ) : string 
    {
        $recipient = User::where('username', '=', $username)->first();

        if ( $recipient === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestByRecipient($recipient);
        if ( !$request ) {
            return 'Request in not valid.';
        }
        
        $this->dropRequestFromBb($request);
        return 'Friend request canceled.';
    }

    private function checkAreYouRecipient( User $recipient ) : bool 
    {
        if ( $recipient->id === Auth::user()->id ) {
            return true;
        }
        return false;
    }

    private function checkRecipientIsAlreadyYouFriend( User $recipient ) : bool 
    {
        $check = Friend::where('user_id', '=', Auth::user()->id)
            ->where('friend_user_id', '=', $recipient->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkWasThisRequestSentEarlier( User $recipient ) : bool 
    {
        $check = FriendRequestTable::where('sender_id', '=', Auth::user()->id)
            ->where('recipient_id', '=', $recipient->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkRequestWasReceivedFromThisUser( User $recipient ) : bool 
    {
        $check = FriendRequestTable::where('sender_id', '=', $recipient->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function getUserByUsername( string $recipientUsername ) 
    {
        return User::where('username', '=', $recipientUsername)->first();
    }

    private function storeRequestIntoDatabase($recipientUser) 
    {
        $friendshipRequest = new FriendRequestTable();
        $friendshipRequest->sender_id = Auth::user()->id;
        $friendshipRequest->recipient_id = $recipientUser->id;
        $friendshipRequest->confirm_status = 0;
        $friendshipRequest->save();
    }

    private function getRequestBySender( User $sender ) 
    {
        return FriendRequestTable::where('sender_id', '=', $sender->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();   
    }

    private function getRequestByRecipient( User $recipient ) 
    {
        return FriendRequestTable::where('recipient_id', '=', $recipient->id)
            ->where('sender_id', '=', Auth::user()->id)
            ->first();   
    }

    private function buildFriendshipsContact( FriendRequestTable $request, User $userSender ) 
    {
        $this->dropRequestFromBb($request);
        $this->addFriendRowForRecipient($userSender);
        $this->addFriendRowForSender($userSender);
    }

    private function addFriendRowForRecipient( User $sender) 
    {
        $friend = new Friend();
        $friend->user_id = Auth::user()->id;
        $friend->friend_user_id = $sender->id;
        $friend->save();
    }

    private function addFriendRowForsender( User $sender) 
    {
        $friend = new Friend();
        $friend->user_id = $sender->id;
        $friend->friend_user_id = Auth::user()->id;
        $friend->save();
    }

    private function dropRequestFromBb( FriendRequestTable $request ) 
    {
        FriendRequestTable::where('id', '=', $request->id)->delete();
    }

}