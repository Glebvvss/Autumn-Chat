<?php

namespace Tests\Feature\ControllerTests;

use Hash;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquent\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin() 
    {
        $response = $this->call('POST', '/login', [
          'username' => 'testuser1',
          'password' => 'password',
        ]);
        $response->assertStatus(200);

        $this->assertEquals( Auth::user(), User::where('username', '=', 'testuser1')->first() );

        Auth::logout();
    }

    public function testRegistration() 
    {
        $response = $this->call('POST', '/registration', [
          'username'        => 'testuser1',
          'email'           => 'testuser1@example.com',
          'password'        => 'password',
          'confirmPassword' => 'password',
        ]);
        $response->assertStatus(200);

        $this->assertEquals( Auth::user(), User::where('username', '=', 'testuser1')->first() );

        Auth::logout();
    }

    public function testCheckLoginOnGuestStatus()
    {
        $response = $this->call('GET', '/check-login');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'guest'
        ]);
    }

    public function testCheckLoginOnUserStatus()
    {
        $response = $this->call('POST', '/login', [
          'username' => 'testuser1',
          'password' => 'password',
        ]);

        $response = $this->call('GET', '/check-login');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'guest'
        ]);
    }

    public function testLogout()
    {
        $this->addTestUsersToDatabase();

        $response = $this->call('POST', '/login', [
          'username' => 'testuser1',
          'password' => 'password',
        ]);

        $this->assertEquals( Auth::user(), User::where('username', '=', 'testuser1')->first() );

        $response = $this->call('GET', '/logout');

        $response = $this->call('GET', '/check-login');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'guest'
        ]);
    }

    private function addTestUsersToDatabase()
    {
        $user = new User();
        $user->username = 'testuser1';
        $user->email    = 'testuser1@example.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}