<?php 

namespace App\Services\Interfaces;

interface IMessageService 
{
    public function sendTo(int $contactId, string $text);

       
}