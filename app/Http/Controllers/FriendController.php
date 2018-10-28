<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IFriendService as FriendService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;

class FriendController extends Controller
{
    protected $friendService;
    protected $unreadMessageLinkService;

    public function __construct(
        FriendService $friendService,
        UnreadMessageLinkService $unreadMessageLinkService
    ){
        $this->friendService = $friendService;
        $this->unreadMessageLinkService = $unreadMessageLinkService;
    }

    public function getAll()
    {
        $friends = $this->friendService->getAllOfUser(
            Auth::user()->id
        );

        $friendsWithUnreadMessageLinks = $this->unreadMessageLinkService->attachToFriendListByDialogs(
            $friends
        );
        
        return response()->json([
            'friends' => $friendsWithUnreadMessageLinks
        ]);
    }

    public function deleteFromFriendList(Request $request)
    {
        $this->friendService->deleteFromFriends($request->friendId);

        event( new UpdateFriendList($request->friendId) );
    }

    public function getAllWhoNotInGroup(Request $request) 
    {
        $friendsWhoNotInGroup = $this->friendService->getAllWhoNotInGroup(
            $request->groupId
        );
        
        return response()->json([
            'friendsWhoNotInGroup' => $friendsWhoNotInGroup
        ]);
    }
}