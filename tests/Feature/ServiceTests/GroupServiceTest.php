<?php

namespace Tests\Feature\ServiceTests;

use DB;
use Hash;
use Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Friend;
use App\Models\Group;
use App\Models\FriendshipRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Realizations\GroupService;

class GroupServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSuccess()
    {
        $userFirst = new User();
        $userFirst->username = 'testuser1';
        $userFirst->email = 'testuser1@example.com';
        $userFirst->password = Hash::make('password');
        $userFirstID = $userFirst->save();

        $userSecond = new User();
        $userSecond->username = 'testuser2';
        $userSecond->email = 'testuser2@example.com';
        $userSecond->password = Hash::make('password');
        $userSecondID = $userSecond->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $groupService = new GroupService();
        $result = $groupService->create('group_name', [$userSecondID]);

        $this->assertEquals($result, 'Group created!');

        Auth::logout();
    }

    public function testCreateWithEmptyGroupName()
    {
        $userFirst = new User();
        $userFirst->username = 'testuser1';
        $userFirst->email = 'testuser1@example.com';
        $userFirst->password = Hash::make('password');
        $userFirstID = $userFirst->save();

        $userSecond = new User();
        $userSecond->username = 'testuser2';
        $userSecond->email = 'testuser2@example.com';
        $userSecond->password = Hash::make('password');
        $userSecondID = $userSecond->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $groupService = new GroupService();
        $result = $groupService->create('', [$userSecondID]);

        $this->assertEquals($result, 'Group name cannot be empty.');

        Auth::logout();
    }

    public function testCreateWithEmptyUserList()
    {
        $userFirst = new User();
        $userFirst->username = 'testuser1';
        $userFirst->email = 'testuser1@example.com';
        $userFirst->password = Hash::make('password');
        $userFirstID = $userFirst->save();

        $userSecond = new User();
        $userSecond->username = 'testuser2';
        $userSecond->email = 'testuser2@example.com';
        $userSecond->password = Hash::make('password');
        $userSecondID = $userSecond->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $groupService = new GroupService();
        $result = $groupService->create('group_name', []);

        $this->assertEquals($result, 'No users in member list of group.');

        Auth::logout();
    }

}