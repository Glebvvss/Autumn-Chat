<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
Use App\Models\FriendshipRequestMaker;

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

    public function sendAnRequestForFriendship(Request $request) {
        $friendshipRequestMaker = new FriendshipRequestMaker();
        return $friendshipRequestMaker->sendRequest($request->friendUsername);
    }

    public function confirmAnRequestForFriendship(Request $request) {
        echo 'test';
    }

    public function cancelAnRequestForFriendship() {
        echo 'test';   
    }

}
