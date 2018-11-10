<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Events\UpdateHistory;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IFriendService as FriendService;
use App\Services\Interfaces\IHistoryServices\IHistoryService as HistoryService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;

class FriendController extends Controller
{
    protected $friendService;
    protected $historyService;
    protected $unreadMessageLinkService;

    public function __construct(
        FriendService            $friendService,
        HistoryService           $historyService,
        UnreadMessageLinkService $unreadMessageLinkService
    ){
        $this->friendService            = $friendService;
        $this->historyService           = $historyService;
        $this->unreadMessageLinkService = $unreadMessageLinkService;
    }

    public function getAll()
    {
        $friends =  $this->friendService->getAllOfUser(
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

        $this->historyService->makeNew(
            'You deleted a friend named ' . User::find($request->friendId)->username,
            Auth::user()->id
        );

        $this->historyService->makeNew(
            'You have been deleted from friends of ' . Auth::user()->username, 
            $request->friendId
        );

        event( new UpdateHistory([
            Auth::user()->id, 
            $request->friendId
        ]));
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