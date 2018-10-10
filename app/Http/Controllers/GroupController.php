<?php

namespace App\Http\Controllers;

use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use App\Eloquent\Friend;
use Illuminate\Http\Request;
use App\Services\Interfaces\GroupEditorService;

class GroupController extends Controller
{

    private $groupEditor;

    public function __construct(GroupEditorService $groupEditor)
    {
        $this->groupEditor = $groupEditor;
    }

    public function getAllPublic() 
    {
        $groups = User::find( Auth::user()->id )
            ->groups()
            ->where('type', '=', 'public')
            ->get()
            ->toArray();

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function createPublic(Request $request) {
        $groupMembersIdList = json_decode($request->groupMembersIdList);
        if ( $request->groupName === null ) {
            $request->groupName = '';
        }

        $result = $this->groupEditor->createPublic($request->groupName, $groupMembersIdList);
        return response()->json([
            'message' => $result
        ]);
    }

    public function leave(Request $request) {
        $this->groupEditor->leaveMemberFrom($request->id, Auth::user()->id);
    }

    public function addNewMembersTo(Request $request) {
        $newGroupMembersIdList = json_decode($request->newGroupMembersIdList);
        $result = $this->groupEditor->addNewMembersTo($request->groupId, $newGroupMembersIdList);
        return response()->json([
            'message' => $result,
        ]);
    }

    public function getMembersOfGroup(Request $request)
    {
        $membersOfGroup = Group::find($request->id)
            ->users()
            ->get()
            ->toArray();

        return response()->json([
          'membersOfGroup' => $membersOfGroup
        ]);
    }
}