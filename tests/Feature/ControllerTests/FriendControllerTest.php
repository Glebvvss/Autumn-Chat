<?php

namespace Tests\Feature\ControllerTests;

use Hash;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquent\User;
use App\Eloquent\Friend;

class FriendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAll() {
        $this->addTestUsersToDatabase();
        $this->addTestFriendsToDatabase();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $response = $this->get('/get-friends')
                         ->assertStatus(200);

        $testuser = User::where('username', '=', 'testuser2')->first();

        $response->assertJson([
            'friends' => [
                [
                    'id' => $testuser->id,
                    'username' => $testuser->username,
                    'online' => $testuser->online
                ]
            ],
        ]);

    }

    private function addTestUsersToDatabase() {
        $user = new User();
        $user->username = 'testuser1';
        $user->email    = 'phpUnitTestUser1@example.com';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->username = 'testuser2';
        $user->email    = 'phpUnitTestUser2@example.com';
        $user->password = Hash::make('password');
        $user->save();
    }

    private function addTestFriendsToDatabase() {
        $friend = new Friend();
        $friend->user_id = User::where('username', '=', 'testuser1')->first()->id;
        $friend->friend_user_id = User::where('username', '=', 'testuser2')->first()->id;
        $friend->save();

        $friend = new Friend();
        $friend->user_id = User::where('username', '=', 'testuser2')->first()->id;
        $friend->friend_user_id = User::where('username', '=', 'testuser1')->first()->id;
        $friend->save();
    }
}