<?php 

namespace App\Models\Contacts\Friends;

use App\Models\Eloquent\Friend;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Interfaces\Recivers\IFriendReciver;

class FriendReciver implements IFriendReciver 
{

    public function getById( int $id ) : Friend 
    {
        $friend = Friend::with(['userFriend' => function($query) {

            $query->select('id', 'username', 'online');

        }])->select('friend_user_id', 'new')
           ->where( 'user_id', '=', Auth::user()->id )
           ->where( 'friend_user_id', '=', $id )
           ->first();

        return $friend;
    }

    public function getByUsername( string $username ) : Friend 
    {
        $friend = Friend::with(['userFriend' => function($query) {

            $query->select('id', 'username', 'online')
                  ->where('username', '=', $username);

        }])->select('friend_user_id', 'new')
           ->where( 'user_id', '=', Auth::user()->id )
           ->first();

        return $friend;
    }

    public function getByEmail( string $email ) 
    {
        $friend = Friend::with(['userFriend' => function($query) {

            $query->select('id', 'username', 'online')
                  ->where('email', '=', $email);

        }])->select('friend_user_id', 'new')
           ->where( 'user_id', '=', Auth::user()->id )
           ->first();

        return $friend;
    }

    public function getAll() : Collection 
    {
        $friends = Friend::with(['userFriend' => function($query) {

            $query->select('id', 'username', 'online');

        }])->select( 'friend_user_id', 'new' )
           ->where( 'user_id', '=', Auth::user()->id )
           ->get();

        return $friends;
    }

}