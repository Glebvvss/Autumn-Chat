<?php 

namespace App\Services\Interfaces\IHistoryServices;

interface IHistoryWriterService
{
    public function friendAdded(int $friendId) : array;

    public function sendedFriendshipRequestCanceled(int $userId) : array;

    public function reciviedFriendshipRequestCanceled(int $userId) : array;

    public function friendshipRequestSended(int $userId) : array;

    public function groupCreatedBy(int $userCreatorId, int $groupId) : array;

    public function leaveFromGroup(int $userId, int $groupId) : array;

    public function addNewMembersToGroup(array $newMemberIdList, int $groupId) : array;
}