<?php

namespace App\Http\Controllers;

use Auth;
use App\Eloquent\User;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Events\UpdateFriendRequestList;
use App\Services\Interfaces\Search\SearchUser;
use App\Services\Interfaces\Contacts\Friends\ReciveFriend;

class FriendController extends Controller 
{
    protected $reciveFriend;

    public function __construct (ReciveFriend $reciveFriend) {
        $this->reciveFriend = $reciveFriend;
    }

    public function getAll() 
    {
        $friends = $this->reciveFriend->all();
        return response()->json([
            'friends' => $friends
        ]);
    }

}