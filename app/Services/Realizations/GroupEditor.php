<?php

namespace App\Services\Realizations;

use Auth;
use App\Eloquent\User;
use App\Eloquent\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\GroupEditorService;

class GroupEditor implements GroupEditorService
{
    public function createPublic(string $groupName, array $memberListId)
    {
        if ( $groupName === '' ) {
            return 'Group name cannot be empty.';
        }

        if ( empty($memberListId) ) {
            return 'No users in member list of group.';
        }

        $newGroupId = $this->createNewEmptyGroup($groupName, 'public');
        $this->associateUsersWithGroups($newGroupId, $memberListId);

        return 'Group created!';
    }

    public function createIndividualBetween(int $userId, int $otherUserId)
    {
        if ( !$userId || !$otherUserId ) {
            throw new \Exception('Not exists user id numbers.');
        }

        if ( !$this->validateIndividualGroupOnExists($userId, $otherUserId) ) {
            throw new \Exception('This group already exists.');
        }

        $groupName = $this->generateIndividualGroupName($userId, $otherUserId);
        $newGroupId = $this->createNewEmptyGroup($groupName, 'individual');
        $this->associateUsersWithIndividualGroups($newGroupId, $userId, $otherUserId);
    }

    private function associateUsersWithIndividualGroups(
        int $groupId, 
        int $userId, 
        int $otherUserId
    ){
        $user = User::find($userId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();

        $user = User::find($otherUserId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();
    }

    private function validateIndividualGroupOnExists(int $userId, int $otherUserId) : bool
    {
        $groupName = 'DIALOG_BETWEEN_'.$userId.'_AND_'.$otherUserId;
        $alternativeGroupName = 'DIALOG_BETWEEN_'.$otherUserId.'_AND_'.$userId;

        $check = Group::where([
            ['group_name', '=', $groupName], 
            ['type', '=', 'individual']
        ])->orWhere([
            ['group_name', '=', $alternativeGroupName],
            ['type', '=', 'individual']
        ])->first();

        if ( $check ) {
            return false;
        }
        return true;
    }

    private function generateIndividualGroupName(int $userId, int $otherUserId) : string
    {
        return  'DIALOG_BETWEEN_'.$userId.'_AND_'.$otherUserId;
    }

    public function addNewMembersTo(int $groupId, array $listUserId) 
    {        
        foreach( $listUserId as $userId ) {
            $user = User::find($userId);

            $group = Group::find($groupId);
            $group->users()->attach($user);
            $group->save();
        }

        return 'New members to group added.';
    }

    public function leaveMemberFrom(int $groupId, int $userId) 
    {
        $user = User::find($userId);
        
        $group = Group::find($groupId);
        $group->users()->detach($user);
        $group->save();
    }

    private function createNewEmptyGroup(string $groupName, string $type)
    {
        if ( $type !== 'public' && $type !== 'individual' ) {
            throw new \Exception('Incorrect type of group.');
        }

        $group = new Group();
        $group->group_name = $groupName;
        $group->type = $type;
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

    private function addGroupCreatorToMemberList($memberListId) 
    {
        $memberListId[] = Auth::user()->id;
        return $memberListId;
    }

}