<?php

namespace App\Services\Interfaces\IGroupServices;

use Illuminate\Database\Eloquent\Collection;

interface IBaseGroupService
{
    public function getMembers(int $groupId) : Collection;

    public function getMembersId(int $groupId) : array;

    public function getMembersIdWithoutSender(int $groupId) : array;
}