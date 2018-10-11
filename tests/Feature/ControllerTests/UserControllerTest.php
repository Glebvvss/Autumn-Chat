<?php

namespace Tests\Feature\ControllerTests;

use Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsername()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
                         ->get('/get-username')
                         ->assertStatus(200);

        $response->assertJson([
            'username' => $user->username,
        ]);
    }

    public function testGetId()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
                         ->get('/get-user-id')
                         ->assertStatus(200);

        $response->assertJson([
            'userId' => $user->id,
        ]);
    }

    public function testSearchByOccurrenceWithMatches()
    {
        $this->addTestUsersToDatabase();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
                         ->get('/search-friend/phpUnitTestUser')
                         ->assertStatus(200);

        $response->assertJson([
            'matchUsernames' => [
                ['username' => 'phpUnitTestUser1'],
                ['username' => 'phpUnitTestUser2'],
            ],
        ]);
    }

    public function testSearchByOccurrenceWithoutMatches()
    {
        $this->addTestUsersToDatabase();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
                         ->get('/search-friend/oiu')
                         ->assertStatus(200);

        $response->assertJson([
            'matchUsernames' => []
        ]);
    }

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