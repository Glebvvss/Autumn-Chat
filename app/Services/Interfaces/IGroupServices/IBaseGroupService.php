<?php

namespace App\Services\Interfaces\IGroupServices;

interface IBaseGroupService
{
    public function getMembers(int $groupId);

    public function getMembersId(int $groupId);

    public function getMembersIdWithoutSender(int $groupId);
}