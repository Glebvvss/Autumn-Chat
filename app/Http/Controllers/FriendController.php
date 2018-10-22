<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IFriendService as FriendService;

class FriendController extends Controller
{
    private $friendService;

    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
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
        $friendsWhoNotInGroup = $this->friendService->getAllWhoNotInGroup($request->groupId);
        return response()->json([
            'friendsWhoNotInGroup' => $friendsWhoNotInGroup
        ]);
    }
}