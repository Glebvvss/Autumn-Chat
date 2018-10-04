<?php

namespace Tests\Feature\ControllerTests;

use Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquent\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    

    private function addTestUsersToDatabase() {
        $user = new User();
        $user->username = 'phpUnitTestUser1';
        $user->email    = 'phpUnitTestUser1@example.com';
        $user->password = 'password';
        $user->save();

        $user = new User();
        $user->username = 'phpUnitTestUser2';
        $user->email    = 'phpUnitTestUser2@example.com';
        $user->password = 'password';
        $user->save();
    }
}