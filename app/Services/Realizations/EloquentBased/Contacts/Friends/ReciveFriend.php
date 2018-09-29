<?php 

namespace App\Services\Realizations\EloquentBased\Contacts\Friends;

use Auth;
use App\ORM\Eloquent\Friend;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\Contacts\Friends\ReciveFriend as ReciveFriendInterface;

class ReciveFriend implements ReciveFriendInterface
{

    public function byId( int $id ) : array 
    {
        $friend = Friend::with(['userFriend' => function($query) 
        {
            $query->select('id', 'username', 'online');
        }
        ])->select('friend_user_id', 'new')
          ->where( 'user_id', '=', Auth::user()->id )
          ->where( 'friend_user_id', '=', $id )
          ->first()
          ->toArray();

        return $friend;
    }

    public function byUsername( string $username ) : array
    {
        $friend = Friend::with(['userFriend' => function($query) 
        {
            $query->select('id', 'username', 'online')
                  ->where('username', '=', $username);
        }
        ])->select('friend_user_id', 'new')
          ->where( 'user_id', '=', Auth::user()->id )
          ->first()
          ->toArray();

        return $friend;
    }

    public function byEmail( string $email ) : array
    {
        $friend = Friend::with(['userFriend' => function($query) 
        {
            $query->select('id', 'username', 'online')
                  ->where('email', '=', $email);
        }
        ])->select('friend_user_id', 'new')
          ->where( 'user_id', '=', Auth::user()->id )
          ->first()
          ->toArray();

        return $friend;
    }

    public function all() : array 
    {
        $friends = Friend::with(['userFriend' => function($query) 
        {
            $query->select('id', 'username', 'online');
        }
        ])->select( 'friend_user_id', 'new' )
          ->where( 'user_id', '=', Auth::user()->id )
          ->get()
          ->toArray();

        return $friends;
    }

}