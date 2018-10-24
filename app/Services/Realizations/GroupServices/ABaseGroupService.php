<?php 

namespace App\Services\Realizations\GroupServices;

abstract class ABaseGroupService
{
    public function getMembers(int $groupId) : Collection
    {
        return Group::find($groupId)->users()->get();
    }
}