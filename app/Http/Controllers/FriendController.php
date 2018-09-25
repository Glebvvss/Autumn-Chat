<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use App\Models\Contacts\FriendManager;
use App\Models\Eloquent\FriendshipRequest;
use App\Models\Contacts\FriendshipRequestMaker;
use App\Events\FriendshipRequestConfirmed as RequestConfirmed;

class FriendController extends Controller {

    public function searchFriendByOccurrenceOfUsername(Request $request) {
        $friendManager = new FriendManager();        
        $matchUsernames = $friendManager->searchFriends($request->usernameOccurrence);
        
        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }

    public function getFriends() {
        $friendManager = new FriendManager();
        $friends = $friendManager->getFriends(Auth::user()->id);

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function getFrendshipRequests() {
        $friendManager = new FriendManager();
        $friendshipRequests = $friendManager->getFriendsipRequests(Auth::user()->id);

        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function sendFriendshipRequest(Request $request) {
        $friendManager = new FriendManager();
        $result = $friendManager->sendFriendshipRequest($request->recipientUsername);

        return response()->json([
            'message' => $result
        ]);
    }

    public function confirmFriendshipRequest(Request $request) {
        $friendManager = new FriendManager();
        $result = $friendManager->confirmFriendshipRequest($request->senderUsername);

        if ( $result !== 'Friend added!' ) {
            return response()->json([
                'message' => $result
            ]);
        }

        $sender = User::where('username', '=', $request->senderUsername)->first();
        $newFriendForRecipient = $friendManager->getFriend( Auth::user()->id, $sender->id );
        return response()->json([
            'message' => $result,
            'friend' => $newFriendForRecipient
        ]);
    }

    public function cancelFriendshipRequest(Request $request) {
        $friendManager = new FriendManager();
        $result = $friendManager->cancelFriendshipRequest($request->senderUsername);

        return response()->json([
            'message' => $result
        ]);
    }

}