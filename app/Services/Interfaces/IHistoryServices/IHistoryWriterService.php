<?php 

namespace App\Services\Interfaces\IHistoryServices;

interface IHistoryWriterService
{
    public function friendAdded(int $friendId) : void;

    public function sendedFriendshipRequestCanceled(int $userId) : void;

    public function reciviedFriendshipRequestCanceled(int $userId) : void;

    public function friendshipRequestSended(int $userId) : void;

    public function groupCreatedBy(int $userCreatorId, int $groupId) : void;

    public function leaveFromGroup(int $userId, int $groupId) : void;

    public function addNewMembersToGroup(array $newMemberIdList, int $groupId) : void;
}