<?php

namespace App\Models\Contacts\Friends;

use Auth;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use Illuminate\Database\Eloquent\Model;
use App\Models\Eloquent\FriendshipRequest;
use Illuminate\Database\Eloquent\Collection;

class FriendshipRequestMaker {

    public function sendRequest( string $recipientUsername ) : string {
        $recipient = $this->getUserByUsername($recipientUsername);
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

    private function checkAreYouRecipient( User $recipient ) : bool {
        if ( $recipient->id === Auth::user()->id ) {
            return true;
        }
        return false;
    }

    private function checkRecipientIsAlreadyYouFriend( User $recipient ) : bool {
        $check = Friend::where('user_id', '=', Auth::user()->id)
            ->where('friend_user_id', '=', $recipient->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkWasThisRequestSentEarlier( User $recipient ) : bool {
        $check = FriendshipRequest::where('sender_id', '=', Auth::user()->id)
            ->where('recipient_id', '=', $recipient->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkRequestWasReceivedFromThisUser( User $recipient ) : bool {
        $check = FriendshipRequest::where('sender_id', '=', $recipient->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function getUserByUsername( string $recipientUsername ) {
        return User::where('username', '=', $recipientUsername)->first();
    }

    private function storeRequestIntoDatabase($recipientUser) {
        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = Auth::user()->id;
        $friendshipRequest->recipient_id = $recipientUser->id;
        $friendshipRequest->confirm_status = 0;
        $friendshipRequest->save();
    }

    public function confirmRequest( string $senderUsername ) : string {
        $sender = User::where('username', '=', $senderUsername)->first();

        if ( $sender === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestFromDb($sender);
        if ( !$request ) {
            return 'Request in not exists.';
        }

        $this->buildFriendshipsContact($request, $userSender);
        return 'Friend added!';
    }

    private function getRequestBySender( User $sender ) {
        return FriendshipRequest::where('sender_id', '=', $sender->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();   
    }

    private function getRequestByRecipient( User $recipient ) {
        return FriendshipRequest::where('recipient_id', '=', $recipient->id)
            ->where('sender_id', '=', Auth::user()->id)
            ->first();   
    }

    private function buildFriendshipsContact( FriendshipRequest $request, User $userSender ) {
        $this->dropRequestFromBb($request);
        $this->addFriendRowForRecipient($userSender);
        $this->addFriendRowForSender($userSender);
    }

    private function addFriendRowForRecipient( User $sender) {
        $friend = new Friend();
        $friend->user_id = Auth::user()->id;
        $friend->friend_user_id = $sender->id;
        $friend->save();
    }

    private function addFriendRowForsender( User $sender) {
        $friend = new Friend();
        $friend->user_id = $sender->id;
        $friend->friend_user_id = Auth::user()->id;
        $friend->save();
    }

    public function cancelRecivedRequest( string $senderUsername ) : string {
        $sender = User::where('username', '=', $senderUsername)->first();

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

    public function cancelSendedRequest( string $recipientUsername ) : string {
        $recipient = User::where('username', '=', $recipientUsername)->first();

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

    private function dropRequestFromBb( FriendshipRequest $request ) {
        FriendshipRequest::where('id', '=', $request->id)->delete();
    }

}