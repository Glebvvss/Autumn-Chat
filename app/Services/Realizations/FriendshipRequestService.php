<?php

namespace App\Services\Realizations;

use Auth;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendshipRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\IFriendshipRequestService;

class FriendshipRequestService implements IFriendshipRequestService
{
    public function sendTo( string $username ) : string
    {
        $user = $this->getUserByUsername($username);
        if ( !$user ) {
            return 'This user is not exists.';
        }
        if ( !$this->checkAreYouRecipient($user->id) ) {
            return 'You can`t send requests to yourself.';
        }
        if ( !$this->checkRecipientIsAlreadyYouFriend($user->id) ) {
            return 'This user is already your friend.';
        }
        if ( !$this->checkWasThisRequestSentEarlier($user->id) ) {
            return 'This request already has been sent.';
        }
        if ( !$this->checkRequestWasReceivedFromThisUser($user->id) ) {
            return 'Already You have request from this user.';
        }
        $this->storeRequestIntoDatabase($user->id);
        return 'Request has been sent.';
    }

    private function getUserByUsername( string $username ) 
    {
        return User::where('username', '=', $username)->first();
    }

    private function getUserById( int $id ) 
    {
        return User::find($id);
    }

    private function checkUserById( int $id ) : bool 
    {
        $check = User::find($id);
        if ( $check ) {
            return true;
        }
        return false;
    }

    public function confirmFrom( int $id ) : string 
    {
        if ( !$this->checkUserById($id) ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestBySender($id);
        if ( !$request ) {
            return 'Request is not exists.';
        }

        $this->buildFriendshipsContact( $request, $id );
        return 'Friend added!';
    }
    
    public function cancelRecivedFrom( int $id ) : string 
    {
        if ( !$this->checkUserById($id) ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestBySender($id);
        if ( !$request ) {
            return 'Request is not valid.';
        }

        $this->dropRequestFromBb($request);
        return 'Friendship request canceled.';
    }

    public function cancelSendedTo( int $id ) : string 
    {
        if ( !$this->checkUserById($id) ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestByRecipient($id);
        if ( !$request ) {
            return 'Request in not valid.';
        }
        
        $this->dropRequestFromBb($request);
        return 'Friendship request canceled.';
    }

    public function countNewRecived()
    {
        $count = FriendshipRequest::where('recipient_id', '=', Auth::user()->id)
            ->where('new', '=', 1)
            ->count();

        return $count;
    }

    public function readByRecipient()
    {
        FriendshipRequest::where('recipient_id', '=', Auth::user()->id)->update([
            'new' => 0
        ]);
    }

    private function checkAreYouRecipient( int $id ) : bool 
    {
        if ( $id !== Auth::user()->id ) {
            return true;
        }
        return false;
    }

    private function checkRecipientIsAlreadyYouFriend( int $id ) : bool 
    {
        $check = Friend::where( 'user_id', '=', Auth::user()->id )
            ->where( 'friend_user_id', '=', $id )
            ->first();

        if ( $check ) {
            return false;
        }
        return true;
    }

    private function checkWasThisRequestSentEarlier( int $id ) : bool 
    {
        $check = FriendshipRequest::where( 'sender_id', '=', Auth::user()->id )
            ->where( 'recipient_id', '=', $id )
            ->first();

        if ( $check ) {
            return false;
        }
        return true;
    }

    private function checkRequestWasReceivedFromThisUser( int $id ) : bool 
    {
        $check = FriendshipRequest::where( 'sender_id', '=', $id )
            ->where( 'recipient_id', '=', Auth::user()->id )
            ->first();

        if ( $check ) {
            return false;
        }
        return true;
    }

    private function storeRequestIntoDatabase( int $id ) 
    {
        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = Auth::user()->id;
        $friendshipRequest->recipient_id = $id;
        $friendshipRequest->save();
    }

    private function getRequestBySender( int $id ) 
    {
        return FriendshipRequest::where( 'sender_id', '=', $id )
            ->where( 'recipient_id', '=', Auth::user()->id )
            ->first();   
    }

    private function getRequestByRecipient( int $id ) 
    {
        return FriendshipRequest::where( 'recipient_id', '=', $id )
            ->where( 'sender_id', '=', Auth::user()->id )
            ->first();   
    }

    private function buildFriendshipsContact( FriendshipRequest $request, int $idSender ) 
    {
        $this->dropRequestFromBb($request);
        $this->addFriendRowForRecipient($idSender);
        $this->addFriendRowForSender($idSender);
    }

    private function addFriendRowForRecipient( int $id ) 
    {
        $friend = new Friend();
        $friend->user_id = Auth::user()->id;
        $friend->friend_user_id = $id;
        $friend->save();
    }

    private function addFriendRowForsender( int $id ) 
    {
        $friend = new Friend();
        $friend->user_id = $id;
        $friend->friend_user_id = Auth::user()->id;
        $friend->save();
    }

    private function dropRequestFromBb( FriendshipRequest $request ) 
    {
        FriendshipRequest::where('id', '=', $request->id)->delete();
    }

}