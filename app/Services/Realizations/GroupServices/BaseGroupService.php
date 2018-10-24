<?php 

namespace App\Services\Realizations\GroupServices;

use App\Models\Group;
use App\Services\Interfaces\IGroupServices\IBaseGroupService;

class BaseGroupService implements IBaseGroupService
{
    public function getMembers(int $groupId) : Collection
    {
        return Group::find($groupId)->users()->get();
    }

    public function getMembersId(int $groupId) : array
    {
        $members = Group::find($groupId)
                        ->users()
                        ->get()
                        ->toArray();

        return $this->generateMembersIdArray($members);
    }

    private function generateMembersIdArray(array $members) : array
    {
        $membersId = [];
        foreach($members as $member) {
            $membersId[] = $member['id'];
        }
        return $membersId;
    }
}