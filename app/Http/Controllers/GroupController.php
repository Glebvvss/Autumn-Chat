<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IPublicTypeGroupService as PublicTypeGroupService;
use App\Services\Interfaces\IDialogTypeGroupService as DialogTypeGroupService;

class GroupController extends Controller
{
    private $publicTypeGroupService;
    private $dialogTypeGroupService;

    public function __construct(
        PublicTypeGroupService  $publicTypeGroupService,
        DialogTypeGroupService  $dialogTypeGroupService
    ){
        $this->publicTypeGroupService = $publicTypeGroupService;
        $this->dialogTypeGroupService = $dialogTypeGroupService;
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
        $dialogId = $this->dialogTypeGroupService->getDialogIdBetween(
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

        $result = $this->publicTypeGroupService->create($request->groupName, $groupMembersIdList);
        return response()->json([
            'message' => $result
        ]);
    }

    public function leaveFromPublicType(Request $request) {
        $this->publicTypeGroupService->leaveMemberFrom($request->id, Auth::user()->id);
    }

    public function addNewMembersToPublicType(Request $request) {
        $newGroupMembersIdList = json_decode($request->newGroupMembersIdList);
        $result = $this->publicTypeGroupService->addNewMembersTo($request->groupId, $newGroupMembersIdList);
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