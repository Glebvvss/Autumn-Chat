<?php

namespace App\Services\Realizations;

use DB;
use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use App\Services\Interfaces\ReciveFriendService;

class ReciveFriend implements ReciveFriendService
{
    public function getAllWhoNotInGroup(int $groupId) 
    {
        if ( !$this->checkGroupOnExists($groupId) ) {
            return;
        }

        $groupMembers = $this->getMembersGroup($groupId);

        $friends = DB::table('users')
            ->select('users.id as id', 'users.username as username')
            ->join('friends', 'users.id', 'friends.friend_user_id');

        $friends->where('friends.user_id', '=', Auth::user()->id);
        foreach( $groupMembers as $groupMember ) {
            $friends->where('friends.friend_user_id', '<>', $groupMember->id);
        }

        return $friends->get();
    }

    private function getMembersGroup(int $groupId) 
    {
        return DB::table('group_user')
            ->leftJoin('groups', 'group_user.group_id', '=', 'groups.id')
            ->leftJoin('users', 'group_user.user_id', '=', 'users.id')
            ->where('groups.id', '=', $groupId)
            ->get();
    }

    private function checkGroupOnExists(int $id)
    {
        $check = Group::find($id);

        if ( $check ) {
            return true;
        }
        return false;
    }

}