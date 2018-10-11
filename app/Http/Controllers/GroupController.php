<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Services\Interfaces\IGroupService as GroupService;

class GroupController extends Controller
{

    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function getAll() 
    {
        $groups = User::find( Auth::user()->id )
            ->groups()
            ->publicType()
            ->get();

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function create(Request $request) {
        $groupMembersIdList = json_decode($request->groupMembersIdList);
        if ( $request->groupName === null ) {
            $request->groupName = '';
        }

        $result = $this->groupService->create($request->groupName, $groupMembersIdList);
        return response()->json([
            'message' => $result
        ]);
    }

    public function leave(Request $request) {
        $this->groupService->leaveMemberFrom($request->id, Auth::user()->id);
    }

    public function addNewMembersTo(Request $request) {
        $newGroupMembersIdList = json_decode($request->newGroupMembersIdList);
        $result = $this->groupService->addNewMembersTo($request->groupId, $newGroupMembersIdList);
        return response()->json([
            'message' => $result,
        ]);
    }

    public function getMembersOfGroup(Request $request)
    {
        $membersOfGroup = Group::find($request->id)
            ->users()
            ->get();

        return response()->json([
          'membersOfGroup' => $membersOfGroup
        ]);
    }
}