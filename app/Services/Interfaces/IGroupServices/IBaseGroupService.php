<?php

namespace App\Services\Interfaces\IGroupServices;

interface IBaseGroupService
{
    public function getMembers(int $groupId);
}