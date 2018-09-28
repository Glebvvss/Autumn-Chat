<?php 

namespace App\Models\Interfaces\Recivers;

interface IRequestReciver 
{
    public function getRecivedRequests();

    public function getSendedRequests();
}