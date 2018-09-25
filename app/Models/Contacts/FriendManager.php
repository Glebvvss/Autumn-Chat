<?php

namespace App\Models\Contacts;

use Auth;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use Illuminate\Database\Eloquent\Model;
use App\Models\Eloquent\FriendshipRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Contacts\FriendshipRequestMaker as RequestMaker;

class FriendManager extends Model {
    
    protected $friendshipRequestMaker;

    public function __construct() {
        $this->friendshipRequestMaker = new RequestMaker();
    }

    public function getFriend( int $userId, int $friendId ) : Friend {
        $friend = Friend::with(['userFriend' => function($query) {
            $query->select('id', 'username');

        }])->select('friend_user_id', 'new')
           ->where( 'user_id', '=', $userId )
           ->where( 'friend_user_id', '=', $friendId )
           ->first();

        return $friend;
    }

    public function getFriends( int $userId ) : Collection {
        $this->checkFriendsOnNewLabel( $userId );

        $friends = Friend::with(['userFriend' => function($query) {
            $query->select('id', 'username', 'online');

        }])->select('friend_user_id', 'new')
           ->where( 'user_id', '=', $userId )
           ->get();

        return $friends;
    }

    protected function checkFriendsOnNewLabel( int $userId ) {
        $date = date('Y-m-d', strtotime("yesterday"));
        $time = date('H:i:s');
        $timestampOf24HoursAgo = $date . ' ' . $time;
        Friend::where('created_at', '<', $timestampOf24HoursAgo)
            ->update(['new' => 0]);
    }

    public function searchFriends( string $usernameQccurance ) : Collection {
        $matchUsernames = User::select('username')
            ->where('username', 'LIKE', $usernameQccurance . '%')
            ->where('username', '<>', Auth::user()->username)
            ->get();

        return $matchUsernames;
    }

    public function getFriendsipRequests( int $userId  ) : Collection {
        $friendshipRequests = FriendshipRequest::with(['userSender' => function($query) {
            $query->select('id', 'username');

        }])->select('id', 'sender_id')
           ->where('recipient_id', '=', $userId)
           ->get();

        return $friendshipRequests;
    }

    public function sendFriendshipRequest( string $recipientUsername ) : string {
        return $this->friendshipRequestMaker->sendRequest($recipientUsername);
    }

    public function confirmFriendshipRequest( string $senderUsername ) : string {
        return $this->friendshipRequestMaker->confirmRequest($senderUsername);
    }

    public function cancelFriendshipRequest( string $senderUsername) : string {
        return $this->friendshipRequestMaker->cancelRequest($senderUsername);
    }

}
