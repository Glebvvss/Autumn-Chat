<?php 

namespace App\Services\Interfaces\IGroupServices;

interface IDialogTypeGroupService 
{ 
    public function createBetween(int $userId, int $otherUserId) : void;

    public function dropBetween(int $userId, int $otherUserId) : void;

    public function getDialogIdBetween(int $userId, int $otherUserId) : int;

    public function findDialog(int $userId, int $otherUserId);
}