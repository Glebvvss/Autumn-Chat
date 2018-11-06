<?php 

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IMessageService 
{
    public function sendTo(int $contactId, string $text) : array;

    public function getLatestAll(int $contactId) : Collection;

    public function getMoreOld(int $contactId, 
                               int $numberScrollLoad, 
                               int $startPointMessageId ) : array;

}