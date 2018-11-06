<?php

namespace App\Services\Interfaces\IGroupServices;

interface IPublicTypeGroupService
{
    public function getAll() : array;

    public function create(string $groupName, array $memberIdList) : array;

    public function addNewMembersTo(int $groupId, array $userIdList) : string;

    public function leaveMemberFrom(int $groupId, int $userId) : void;
}