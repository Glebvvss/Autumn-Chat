<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eloquent\FriendshipRequest;
use App\Models\Eloquent\Friend;
use App\Models\Eloquent\User;
use Auth;

class FriendshipRequestMaker {

    public function __construct() {

    }

    public function sendRequest($usernameOfRecipientRequest) {
        $recipientUser = $this->getUserByUsername($usernameOfRecipientRequest);
        if ( $recipientUser === null ) {
            return response()->json([
                'message' => 'This user in not exists.'
            ]);
        }
        if ( $this->checkAreYouRecipient($recipientUser) ) {
            return response()->json([
                'message' => 'You can`t send requests to youself.'
            ]);
        }
        if ( $this->checkRecipientIsAlreadyYouFriend($recipientUser) === true ) {
            return response()->json([
                'message' => 'This user is already your friend.'
            ]);
        }
        if ( $this->checkWasThisRequestSentEarlier($recipientUser) === true ) {
            return response()->json([
                'message' => 'This request already has been sent.'
            ]);
        }
        if ( $this->checkRequestWasReceivedFromThisUser($recipientUser) === true ) {
            return response()->json([
                'message' => 'Already You have request from this user.'
            ]);
        }
        $this->storeRequestIntoDatabase($recipientUser);
        return response()->json([
            'message' => 'Request has been sent.'
        ]);
    }

    private function checkAreYouRecipient($recipientUser) {
        if ( $recipientUser->id === Auth::user()->id ) {
            return true;
        }
        return false;
    }

    private function checkRecipientIsAlreadyYouFriend($recipientUser) {
        $check = Friend::where('user_id', '=', Auth::user()->id)
            ->where('friend_user_id', '=', $recipientUser->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkWasThisRequestSentEarlier($recipientUser) {
        $check = FriendshipRequest::where('sender_id', '=', Auth::user()->id)
            ->where('recipient_id', '=', $recipientUser->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function checkRequestWasReceivedFromThisUser($recipientUser) {
        $check = FriendshipRequest::where('sender_id', '=', $recipientUser->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();

        if ( $check ) {
            return true;
        }
        return false;
    }

    private function getUserByUsername($usernameOfRecipientRequest) {
        return User::where('username', '=', $usernameOfRecipientRequest)->first();
    }

    private function storeRequestIntoDatabase($recipientUser) {
        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = Auth::user()->id;
        $friendshipRequest->recipient_id = $recipientUser->id;
        $friendshipRequest->confirm_status = 0;
        $friendshipRequest->save();
    }

    public function confirmRequest($usernameSenderRequest) {
        $userSender = User::where('username', '=', $usernameSenderRequest)->first();

        if ( $userSender === null ) {
            return response()->json([
                'message' => 'Sender is not valid.'
            ]);
        }

        $request = $this->getRequestFromDb($userSender);
        if ( !$request ) {
            return response()->json([
                'message' => 'Request in not exists.'
            ]);
        }

        $this->executeRequestAndFriendRowsToDb($request, $userSender);
        return response()->json([
            'message' => 'Friend added!'
        ]);
    }

    private function getRequestFromDb($userSender) {
        return FriendshipRequest::where('sender_id', '=', $userSender->id)
            ->where('recipient_id', '=', Auth::user()->id)
            ->first();   
    }

    private function executeRequestAndFriendRowsToDb($request, $userSender) {
        $this->dropRequestFromBb($request);
        $this->addFriendRowForRecipient($userSender);
        $this->addFriendRowForSender($userSender);
    }

    private function dropRequestFromBb($request) {
        FriendshipRequest::where('id', '=', $request->id)->delete();
    }

    private function addFriendRowForRecipient($userSender) {
        $friend = new Friend();
        $friend->user_id = Auth::user()->id;
        $friend->friend_user_id = $userSender->id;
        $friend->save();
    }

    private function addFriendRowForsender($userSender) {
        $friend = new Friend();
        $friend->user_id = Auth::user()->id;
        $friend->friend_user_id = $userSender->id;
        $friend->save();
    }

    public function cancelRequest($usernameSenderRequest) {
        $userSender = User::where('username', '=', $usernameSenderRequest)->first();

        if ( $userSender === null ) {
            return response()->json([
                'message' => 'Sender is not valid.'
            ]);
        }

        $request = $this->getRequestFromDb($userSender);
        if ( !$request ) {
            return response()->json([
                'message' => 'Request in not valid.'
            ]);
        }
        $this->dropRequestFromBb($request);
        return response()->json([
            'message' => 'Friendship request has been cancel.'
        ]);
    }
}