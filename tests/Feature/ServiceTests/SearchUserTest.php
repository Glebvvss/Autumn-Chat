<?php

namespace Tests\Feature\ServiceTests;

use Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquent\User;

use App\Services\Realizations\SearchUser;

class SearchUserTest extends TestCase
{
    use RefreshDatabase;

    public function testByOccurrenceWithResults() {
        $this->addTestUsersToDatabase();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $searchUser = new SearchUser();
        $mathesUsernames = $searchUser->byOccurrence('phpUnitTestUser');

        $checkResult = [
            ['username' => 'phpUnitTestUser1'],
            ['username' => 'phpUnitTestUser2'],
        ];

        $this->assertEquals($checkResult, $mathesUsernames);
    }

    public function testByOccurrenceWithoutResults() {
        $this->addTestUsersToDatabase();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $searchUser = new SearchUser();
        $mathesUsernames = $searchUser->byOccurrence('adasd876rfhrytr765');

        $checkResult = [];

        $this->assertEquals($checkResult, $mathesUsernames);
    }    

    private function addTestUsersToDatabase() {
        $user = new User();
        $user->username = 'phpUnitTestUser1';
        $user->email    = 'phpUnitTestUser1@example.com';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->username = 'phpUnitTestUser2';
        $user->email    = 'phpUnitTestUser2@example.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}