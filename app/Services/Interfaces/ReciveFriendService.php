<?php

namespace App\Services\Interfaces;

interface ReciveFriendService
{
    public function getAllWhoNotInGroup(int $groupId);
}