<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Events\UpdateHistory;
use App\Events\UpdateFriendList;
use App\Http\Controllers\Controller;
use App\Events\SendHistoryPostsToClients;
use App\Services\Interfaces\IFriendService as FriendService;
use App\Services\Interfaces\IHistoryServices\IHistoryService as HistoryService;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;
use App\Services\Interfaces\IHistoryServices\IHistoryWriterService as HistoryWriterService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;

class FriendController extends Controller
{
    protected $friendService;
    protected $historyService;
    protected $historyWriterService;
    protected $unreadMessageLinkService;

    public function __construct(
        FriendService            $friendService,
        HistoryService           $historyService,
        HistoryWriterService     $historyWriterService,
        UnreadMessageLinkService $unreadMessageLinkService
    ){
        $this->friendService            = $friendService;
        $this->historyService           = $historyService;
        $this->historyWriterService     = $historyWriterService;
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

        $historyPosts = $this->historyWriterService->deleteFromFriendList($request->friendId);

        event( new UpdateFriendList($request->friendId) );
        event( new SendHistoryPostsToClients($historyPosts) );   
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