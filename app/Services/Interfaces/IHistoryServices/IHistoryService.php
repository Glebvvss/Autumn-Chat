<?php 

namespace App\Services\Interfaces\IHistoryServices;

interface IHistoryService 
{
    public function getPage(int $pageNumber, int $startPointPostId) : array;

    public function writeHistoryEvent(string $text, int $userId) : void;

    public function checkOnNewByUserId(int $userId) : bool;

    public function resetNewMarkers() : void;
}