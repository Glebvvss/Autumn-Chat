<?php 

namespace App\Services\Interfaces;

interface IDialogService 
{
    public function createBetween(int $userId, int $otherUserId);

    public function dropBetween(int $userId, int $otherUserId);
}