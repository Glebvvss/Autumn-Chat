<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use Illuminate\Http\Request;
use App\Services\Interfaces\ReciveFriendService;

class FriendController extends Controller
{
    public function getAll()
    {
        $friends = User::find(Auth::user()->id)
            ->friends()
            ->get()
            ->toArray();

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function getAllWhoNotInGroup(
        ReciveFriendService $reciveFriend,
        Request $request
    ){
        $friendsWhoNotInGroup = $reciveFriend->getAllWhoNotInGroup($request->groupId);
        return response()->json([
            'friendsWhoNotInGroup' => $friendsWhoNotInGroup
        ]);
    }
}