<?php

namespace App\Services\Interfaces;

interface IPublicTypeGroupService
{
    public function create(string $groupName, array $memberListId);

    public function addNewMembersTo(int $groupId, array $listUserId);

    public function leaveMemberFrom(int $groupId, int $userId);
}