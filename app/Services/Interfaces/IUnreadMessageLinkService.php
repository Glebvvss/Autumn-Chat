<?php 

namespace App\Services\Interfaces;

interface IUnreadMessageLinkService
{
    public function attachAll(array $groups);

    public function attach(array $group);

    public function attachToFriendListByDialogs(array $friends);

    public function drop(int $groupId);
}