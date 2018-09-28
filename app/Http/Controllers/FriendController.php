<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use App\Events\UpdateFriendList;
use App\Models\Contacts\UserSearcher;
use App\Events\UpdateFriendRequestList;
use App\Models\Contacts\Friends\FriendReciver;
use App\Models\Contacts\Friends\FriendshipRequestMaker;
use App\Models\Contacts\Friends\FriendshipRequestReciver;

class FriendController extends Controller 
{
    public function getFriends() 
    {
        $friendReciver = new FriendReciver();
        $friends = $friendReciver->getAllFriendsById( Auth::user()->id );

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function searchFriends(Request $request) 
    {
        $userSearcher = new UserSearcher();
        $matchUsernames = $userSearcher->searchByOccurrence($request->usernameOccurrence);

        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }

    public function getRecivedFrendshipRequests() 
    {
        $friendshipRequestReciver = new FriendshipRequestReciver();
        $friendshipRequests = $friendshipRequestReciver->getRecivedRequests();

        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function getSendedFrendshipRequests() 
    {
        $friendshipRequestReciver = new FriendshipRequestReciver();
        $friendshipRequests = $friendshipRequestReciver->getSendedRequests();

        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function sendFriendshipRequest(Request $request) 
    {
        $friendshipRequestMaker = new FriendshipRequestMaker();
        $result = $friendshipRequestMaker->sendRequest($request->recipientUsername);

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
        $requestMaker = new FriendshipRequestMaker();
        $result = $requestMaker->confirmRequest($request->senderUsername);;

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
        $requestMaker = new FriendshipRequestMaker();
        $result = $requestMaker->cancelRecivedRequest($request->senderUsername);

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
        $requestMaker = new FriendshipRequestMaker();
        $result = $requestMaker->cancelRecivedRequest($request->senderUsername);

        if ( $result === 'Friend request canceled.' ) {
            $sender = User::where('username', '=', $request->senderUsername)->first();
            event( new UpdateFriendRequestList($sender->id, 'recived') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

}