<?php 

namespace App\Services\Interfaces;

interface IMessageService 
{
    public function sendTo(int $contactId, string $text);

    public function getLatestAll(int $contactId);

    public function getMoreOld(int $contactId, 
                               int $numberScrollLoad, 
                               int $startPointMessageId );

}