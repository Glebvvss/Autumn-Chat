<?php

namespace App\Services\Interfaces\Contacts\Friends;

interface ReciveFriend
{
    public function byId(int $id);

    public function byUsername(string $username);

    public function byEmail(string $email);

    public function all();
}