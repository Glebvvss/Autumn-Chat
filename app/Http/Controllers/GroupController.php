<?php

namespace App\Http\Controllers;

use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use App\Eloquent\Friend;
use Illuminate\Http\Request;

class GroupController extends Controller 
{
    public function getAll() 
    {
        $groups = Group::all();
        return response()->json([
            'groups' => $groups
        ]);
    }

    public function create(Request $request) 
    {
        return response()->json([
          'usersOfGroup' => ''
        ]);
    }

    public function getUsersByGroupId(Request $request) 
    {
        $usersOfGroup = Group::find($request->id)
            ->users()
            ->get()
            ->toArray();

        return response()->json([
          'usersOfGroup' => $usersOfGroup
        ]);
    }
}