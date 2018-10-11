<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\Interfaces\ReciveFriendService;

class FriendController extends Controller
{
    private $reciveFriend;

    public function __construct(ReciveFriendService $reciveFriend)
    {
        $this->reciveFriend = $reciveFriend;
    }

    public function getAll()
    {
        $friends = User::find(Auth::user()->id)
            ->friends()
            ->get();

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function getAllWhoNotInGroup(Request $request) 
    {
        $friendsWhoNotInGroup = $reciveFriend->getAllWhoNotInGroup($request->groupId);
        return response()->json([
            'friendsWhoNotInGroup' => $friendsWhoNotInGroup
        ]);
    }
}