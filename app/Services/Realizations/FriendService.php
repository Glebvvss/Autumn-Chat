<?php

namespace App\Services\Realizations;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use App\Services\Interfaces\IFriendService;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Realizations\GroupServices\DialogTypeGroupService;

class FriendService implements IFriendService
{
    public function getAllOfUser(int $userId) : array
    {
        return User::find($userId)
                   ->friends()
                   ->get()
                   ->toArray();
    }

    public function deleteFromFriends(int $friendId) : void
    {
        Friend::where('user_id', '=', Auth::user()->id)
              ->where('friend_user_id', '=', $friendId)
              ->delete();

        Friend::where('user_id', '=', $friendId)
              ->where('friend_user_id', '=', Auth::user()->id)
              ->delete();

        $dialogTypeGroupService = new DialogTypeGroupService();
        $dialogTypeGroupService->dropBetween(Auth::user()->id, $friendId);
    }

    public function getAllWhoNotInGroup(int $groupId) : Collection
    {
        if ( !$this->checkGroupOnExists($groupId) ) {
            throw new \Exception('Group is not exists');
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

    private function checkGroupOnExists(int $id) : bool
    {
        $check = Group::find($id);

        if ( $check ) {
            return true;
        }
        return false;
    }

}