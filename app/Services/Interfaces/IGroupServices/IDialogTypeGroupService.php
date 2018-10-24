<?php 

namespace App\Services\Interfaces\IGroupServices;

interface IDialogTypeGroupService 
{
    public function createBetween(int $userId, int $otherUserId);

    public function dropBetween(int $userId, int $otherUserId);

    public function getDialogIdBetween(int $userId, int $otherUserId);

    public function findDialog(int $userId, int $otherUserId);
}