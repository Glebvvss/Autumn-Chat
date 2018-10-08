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
    public function getAll() 
    {
        $groups = User::find( Auth::user()->id )
            ->groups()
            ->get()
            ->toArray();

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function create(
        GroupEditorService $groupEditor,
        Request $request
    ){
        $groupMembersIdList = json_decode($request->groupMembersIdList);
        if ( $request->groupName === null ) {
            $request->groupName = '';
        }

        $result = $groupEditor->create($request->groupName, $groupMembersIdList);
        return response()->json([
            'message' => $result
        ]);
    }

    public function addUserTo(Request $request)
    {

    }

    public function removeUserFrom(Request $request)
    {

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