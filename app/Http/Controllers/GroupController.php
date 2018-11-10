<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Models\UnreadMessageLink;
use App\Http\Controllers\Controller;
use App\Events\NewPublicGroupCreated;
use App\Events\UpdateMembersOfPublicGroup;
use App\Services\Interfaces\IGroupServices\IBaseGroupService as BaseGroupService;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;
use App\Services\Interfaces\IHistoryServices\IHistoryWriterService as HistoryWriterService;
use App\Services\Interfaces\IGroupServices\IPublicTypeGroupService as PublicTypeGroupService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;

class GroupController extends Controller
{
    protected $unreadMessageLinkService;
    protected $publicTypeGroupService;
    protected $dialogTypeGroupService;
    protected $historyWriterService;
    protected $baseGroupService;

    public function __construct(
        UnreadMessageLinkService $unreadMessageLinkService,
        PublicTypeGroupService   $publicTypeGroupService,
        DialogTypeGroupService   $dialogTypeGroupService,
        HistoryWriterService     $historyWriterService,
        BaseGroupService         $baseGroupService
    ){
        $this->unreadMessageLinkService = $unreadMessageLinkService;
        $this->publicTypeGroupService   = $publicTypeGroupService;
        $this->dialogTypeGroupService   = $dialogTypeGroupService;
        $this->historyWriterService     = $historyWriterService;
        $this->baseGroupService         = $baseGroupService;
    }

    public function getPublicTypeAll() 
    {
        $groups = $this->publicTypeGroupService->getAll();

        $groupsWithMessageLinks = $this->unreadMessageLinkService->attachAll($groups);

        return response()->json([
            'groups' => $groupsWithMessageLinks
        ]);
    }

    public function getIdOfDialogType(Request $request)
    {
        $dialogId = $this->dialogTypeGroupService->getDialogIdBetween(
                        Auth::user()->id, 
                        $request->friendId
                    );

        return response()->json([
            'dialogId' => $dialogId
        ]);
    }
  
    public function createPublicType(Request $request) {
        $memberIdList = json_decode($request->groupMembersIdList);

        if ( $request->groupName === null ) {
            $request->groupName = '';
        }

        $result = $this->publicTypeGroupService->create(
                      $request->groupName, 
                      $memberIdList
                  );

        if ( $result['message'] === 'Group created!' ) {
            event( new NewPublicGroupCreated($memberIdList) );

            $this->historyWriterService->groupCreatedBy(
                Auth::user()->id, 
                $result['newGroupId']
            );
        }

        return response()->json([
            'message' => $result['message']
        ]);
    }

    public function leaveFromPublicType(Request $request) {
        $this->publicTypeGroupService->leaveMemberFrom(
            $request->groupId, 
            Auth::user()->id
        );

        event( new UpdateMembersOfPublicGroup($request->groupId) );

        $this->historyWriterService->leaveFromGroup(
            Auth::user()->id, 
            $request->groupId
        );
    }

    public function addNewMembersToPublicType(Request $request) {
        $newMembersIdList = json_decode($request->newGroupMembersIdList);

        $result = $this->publicTypeGroupService->addNewMembersTo(
            $request->groupId, 
            $newMembersIdList
        );
        
        if ( $result === 'New members to group added.' ) {
            event( new UpdateMembersOfPublicGroup($request->groupId, $newMembersIdList) );

            $this->historyWriterService->addNewMembersToGroup(
                $newMembersIdList, 
                $request->groupId
            );
        }

        return response()->json([
            'message' => $result,
        ]);
    }

    public function getMembers(Request $request)
    {
        $members = $this->baseGroupService->getMembers($request->id);

        return response()->json([
          'members' => $members
        ]);
    }
}