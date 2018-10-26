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
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;
use App\Services\Interfaces\IGroupServices\IPublicTypeGroupService as PublicTypeGroupService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;

class GroupController extends Controller
{
    protected $publicTypeGroupService;
    protected $dialogTypeGroupService;
    protected $unreadMessageLinkService;

    public function __construct(
        PublicTypeGroupService   $publicTypeGroupService,
        DialogTypeGroupService   $dialogTypeGroupService,
        UnreadMessageLinkService $unreadMessageLinkService
    ){
        $this->publicTypeGroupService   = $publicTypeGroupService;
        $this->dialogTypeGroupService   = $dialogTypeGroupService;
        $this->unreadMessageLinkService = $unreadMessageLinkService;
    }

    public function getPublicTypeAll() 
    {
        $groups = User::find( Auth::user()->id )
            ->groups()
            ->publicType()
            ->get()
            ->toArray();

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

        if ( $result === 'Group created!' ) {
            event( new NewPublicGroupCreated($memberIdList) );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function leaveFromPublicType(Request $request) {
        $this->publicTypeGroupService->leaveMemberFrom($request->id, Auth::user()->id);

        event( new UpdateMembersOfPublicGroup($request->id) );
    }

    public function addNewMembersToPublicType(Request $request) {
        $newMembersIdList = json_decode($request->newGroupMembersIdList);

        $result = $this->publicTypeGroupService->addNewMembersTo(
            $request->groupId, 
            $newMembersIdList
        );
        
        if ( $result === 'New members to group added.' ) {
            event( new UpdateMembersOfPublicGroup($request->id, $newMembersIdList) );
        }

        return response()->json([
            'message' => $result,
        ]);
    }

    public function getMembers(Request $request)
    {
        $members = Group::find($request->id)
            ->users()
            ->get();

        return response()->json([
          'members' => $members
        ]);
    }
}