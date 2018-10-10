<?php

namespace App\Services\Interfaces;

interface GroupEditorService
{
    public function createPublic(string $groupName, array $memberListId);

    public function createIndividualBetween(int $userId, int $otherUserId);

    public function addNewMembersTo(int $groupId, array $listUserId);

    public function leaveMemberFrom(int $groupId, int $userId);
}