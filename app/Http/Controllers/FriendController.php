<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use App\Models\FriendshipRequestMaker;
use App\Models\Eloquent\FriendshipRequest;

class FriendController extends Controller
{
    public function searchFriendByOccurrenceOfUsername(Request $request) {
        $matchUsernames = User::select('username')
            ->where('username', 'LIKE', $request->usernameOccurrence  . '%')
            ->get();

        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }

    public function getFriendsList() {
        $friends = Friend::with('user')
            ->where( 'user_id', '=', Auth::user()->id )
            ->get();

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function getFrendshipRequestsList() {
        $friendshipRequests = FriendshipRequest::with(['userSender' => function($query) {
            $query->select('id', 'username');

        }])->select('id', 'sender_id')
           ->where('recipient_id', '=', Auth::user()->id)
           ->get();

        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function sendFriendshipRequest(Request $request) {
        $friendshipRequestMaker = new FriendshipRequestMaker();
        return $friendshipRequestMaker->sendRequest($request->recipientUsername);
    }

    public function confirmFriendshipRequest(Request $request) {
        $friendshipRequestMaker = new FriendshipRequestMaker();
        return $friendshipRequestMaker->confirmRequest($request->senderUsername);
    }

    public function cancelFriendshipRequest(Request $request) {
        $friendshipRequestMaker = new FriendshipRequestMaker();
        return $friendshipRequestMaker->cancelRequest($request->senderUsername);   
    }

}
