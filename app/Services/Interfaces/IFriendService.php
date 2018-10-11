<?php

namespace App\Services\Interfaces;

interface IFriendService
{
    public function getAllWhoNotInGroup(int $groupId);
}