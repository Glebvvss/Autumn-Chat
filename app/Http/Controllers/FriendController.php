<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Events\UpdateFriendList;
use App\Models\Contacts\UserSearcher;
use App\Events\UpdateFriendRequestList;
use App\Services\Interfaces\Search\SearchUser;
use App\Services\Interfaces\Contacts\Friends\ReciveFriend;
use App\Services\Interfaces\Contacts\Friends\FriendshipRequest;

class FriendController extends Controller 
{
    protected $friendshipRequest;
    protected $reciveFriend;
    protected $searchUser;

    public function __construct (
        FriendshipRequest $friendshipRequest,
        ReciveFriend      $reciveFriend,
        SearchUser        $searchUser
    ) {
        $this->friendshipRequest = $friendshipRequest;
        $this->reciveFriend      = $reciveFriend;
        $this->searchUser        = $searchUser;
    }

    public function getFriends() 
    {
        $friends = $this->reciveFriend->all();
        return response()->json([
            'friends' => $friends
        ]);
    }

    public function searchFriends(Request $request) 
    {
        $matchUsernames = $this->searchUser->byOccurrence($request->usernameOccurrence);
        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }

    public function getRecivedFrendshipRequests() 
    {
        $friendshipRequests = $this->friendshipRequest->getRecivedAll();
        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function getSendedFrendshipRequests() 
    {
        $friendshipRequests = $this->friendshipRequest->getSendedAll();
        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function sendFriendshipRequest(Request $request)
    {
        $result = $this->friendshipRequest->sendTo($request->recipientUsername);
        if ( $result === 'Request has been sent.' ) {
            $recipient = User::where('username', '=', $request->recipientUsername)->first();
            event( new UpdateFriendRequestList($recipient->id, 'recivied') );
            event( new UpdateFriendRequestList(Auth::user()->id, 'sended') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function confirmFriendshipRequest(Request $request)
    {        
        $result = $this->friendshipRequest->confirmFrom($request->senderUsername);;
        if ( $result === 'Friend added!' ) {
            $sender = User::where('username', '=', $request->senderUsername)->first();
            event( new UpdateFriendRequestList($sender->id, 'sended') );
            event( new UpdateFriendList( $sender->id, 'sender' ) );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function cancelReciviedFriendshipRequest(Request $request)
    {
        $result = $this->friendshipRequest->cancelRecivedFrom($request->senderUsername);
        if ( $result === 'Friend request canceled.' ) {
            $sender = User::where('username', '=', $request->senderUsername)->first();
            event( new UpdateFriendRequestList($sender->id, 'sended') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function cancelSendedFriendshipRequest(Request $request)
    {
        $result = $this->friendshipRequest->cancelRecivedRequest($request->senderUsername);
        if ( $result === 'Friend request canceled.' ) {
            $sender = User::where('username', '=', $request->senderUsername)->first();
            event( new UpdateFriendRequestList($sender->id, 'recived') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

}