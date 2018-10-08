<?php

namespace App\Services\Interfaces;

interface GroupEditorService
{
    public function create(string $groupName, array $memberListId);

    public function addMemberTo(int $groupId, int $userId);

    public function leaveMemberFrom(int $groupId, int $userId);
}