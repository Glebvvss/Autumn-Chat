<?php 

namespace App\Services\Interfaces\IHistoryServices;

interface IHistoryService 
{
    public function getSingleLoadList(int $loadNumber, int $startPointPostId) : array;

    public function writeHistoryPost(string $text, int $userId);

    public function checkOnNewByUserId(int $userId) : bool;

    public function resetNewMarkers() : void;
}