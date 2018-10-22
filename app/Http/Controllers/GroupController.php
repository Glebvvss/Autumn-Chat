<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IGroupService as GroupService;
use App\Services\Interfaces\IDialogService as DialogService;

class GroupController extends Controller
{
    private $groupService;

    public function __construct(
        GroupService  $groupService,
        DialogService $dialogService
    ){
        $this->groupService = $groupService;
    }

    public function getPublicTypeAll() 
    {
        $groups = User::find( Auth::user()->id )
            ->groups()
            ->publicType()
            ->get();

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function getIdOfDialogType(Request $request)
    {
        $dialogId = $this->dialogService->getDialogIdBetween(
            Auth::user()->id, 
            $request->friendId
        );

        return response()->json([
            'dialogId' => $dialogId
        ]);
    }

    public function createPublicType(Request $request) {
        $groupMembersIdList = json_decode($request->groupMembersIdList);
        if ( $request->groupName === null ) {
            $request->groupName = '';
        }

        $result = $this->groupService->create($request->groupName, $groupMembersIdList);
        return response()->json([
            'message' => $result
        ]);
    }

    public function leaveFromPublicType(Request $request) {
        $this->groupService->leaveMemberFrom($request->id, Auth::user()->id);
    }

    public function addNewMembersToPublicType(Request $request) {
        $newGroupMembersIdList = json_decode($request->newGroupMembersIdList);
        $result = $this->groupService->addNewMembersTo($request->groupId, $newGroupMembersIdList);
        return response()->json([
            'message' => $result,
        ]);
    }

    public function getMembersOfPublicType(Request $request)
    {
        $membersOfGroup = Group::find($request->id)
            ->users()
            ->get();

        return response()->json([
          'membersOfGroup' => $membersOfGroup
        ]);
    }
}