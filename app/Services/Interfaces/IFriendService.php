<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IFriendService
{
    public function getAllOfUser(int $userId) : array;

    public function deleteFromFriends(int $friendId) : void;

    public function getAllWhoNotInGroup(int $groupId) : Collection;
}