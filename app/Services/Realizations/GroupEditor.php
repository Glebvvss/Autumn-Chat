<?php

namespace App\Services\Realizations;

use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class GroupEditor
{
    public function create(string $groupName, array $memberListId) 
    {
        if ( $groupName === '' ) {
            return 'Group name cannot be empty.';
        }

        if ( empty($memberListId) ) {
            return 'No users in member list of group.';
        }

        $newGroupId = $this->createNewEmptyGroup($groupName);
        $this->associateUsersWithGroups($newGroupId, $memberListId);

        return 'Group created!';
    }

    private function createNewEmptyGroup(string $groupName)
    {
        $group = new Group();
        $group->group_name = $groupName;
        $group->save();

        return $group->id;
    }

    private function associateUsersWithGroups(int $groupId, array $memberListId)
    {
        $memberListIdWithCreator = $this->addGroupCreatorToMemberList($memberListId);

        foreach( $memberListIdWithCreator as $memberId ) {
            $user = User::find($memberId);

            $group = Group::find($groupId);
            $group->users()->attach($user);
            $group->save();
        }
    }

    public function addGroupCreatorToMemberList($memberListId) 
    {
        $memberListId[] = Auth::user()->id;
        return $memberListId;
    }

    public function addMemberTo(int $groupId, int $userId) {

    }

    public function leaveMemberFrom(int $groupId, int $userId) {

    }


}