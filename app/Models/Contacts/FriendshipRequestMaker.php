<?php

namespace App\Models\Contacts;

use Auth;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use Illuminate\Database\Eloquent\Model;
use App\Models\Eloquent\FriendshipRequest;
use Illuminate\Database\Eloquent\Collection;

class FriendshipRequestMaker {

    public function sendRequest( string $usernameOfRecipientRequest ) : string {
        $recipientUser = $this->getUserByUsername($usernameOfRecipientRequest);
        if ( $recipientUser === null ) {
            return 'This user in not exists.';
        }
        if ( $this->checkAreYouRecipient($recipientUser) ) {
            return 'You can`t send requests to youself.';
        }
        if ( $this->checkRecipientIsAlreadyYouFriend($recipientUser) === true ) {
            return 'This user is already your friend.';
        }
        if ( $this->checkWasThisRequestSentEarlier($recipientUser) === true ) {
            return 'This request already has been sent.';
        }
        if ( $this->checkRequestWasReceivedFromThisUser($recipientUser) === true ) {
            return 'Already You have request from this user.';
        }
        $this->storeRequestIntoDatabase($recipientUser);
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

    private function getUserByUsername( string $usernameOfRecipientRequest ) : User {
        return User::where('username', '=', $usernameOfRecipientRequest)->first();
    }

    private function storeRequestIntoDatabase($recipientUser) {
        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = Auth::user()->id;
        $friendshipRequest->recipient_id = $recipientUser->id;
        $friendshipRequest->confirm_status = 0;
        $friendshipRequest->save();
    }

    public function confirmRequest( string $usernameOfSenderRequest ) : string {
        $userSender = User::where('username', '=', $usernameOfSenderRequest)->first();

        if ( $userSender === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestFromDb($userSender);
        if ( !$request ) {
            return 'Request in not exists.';
        }

        $this->executeRequestAndFriendRowsToDb($request, $userSender);
        return 'Friend added!';
    }

    private function getRequestFromDb( User $sender ) {
        return FriendshipRequest::where('sender_id', '=', $sender->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();   
    }

    private function executeRequestAndFriendRowsToDb( FriendshipRequest $request, User $userSender ) {
        $this->dropRequestFromBb($request);
        $this->addFriendRowForRecipient($userSender);
        $this->addFriendRowForSender($userSender);
    }

    private function dropRequestFromBb( FriendshipRequest $request ) {
        FriendshipRequest::where('id', '=', $request->id)->delete();
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

    public function cancelRequest( string $usernameSenderRequest ) : string {
        $userSender = User::where('username', '=', $usernameSenderRequest)->first();

        if ( $userSender === null ) {
            return 'Sender is not valid.';
        }

        $request = $this->getRequestFromDb($userSender);
        if ( !$request ) {
            return 'Request in not valid.';
        }
        $this->dropRequestFromBb($request);
        return 'Friendship request has been cancel.';
    }
}