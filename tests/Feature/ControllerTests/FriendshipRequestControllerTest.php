<?php

namespace Tests\Feature\ControllerTests;

use Hash;
use Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FriendshipRequestControllerTest extends TestCase
{
    public function testGetRecivedAll()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/get-recived-friendship-requests')
             ->assertStatus(200);
    }

    public function testGetSendedAll()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/get-sended-friendship-requests')
             ->assertStatus(200);
    }

    public function testSend()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/send-friendship-request/testusername')
             ->assertStatus(200);
    }

    public function testConfirm()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/confirm-friendship-request/1111')
             ->assertStatus(200);
    }

    public function testCancelRecived()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/cancel-recived-friendship-request/1111')
             ->assertStatus(200);
    }

    public function testCancelSended()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/cancel-sended-friendship-request/1111')
             ->assertStatus(200);
    }

    public function testGetCountNewRecived()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->get('/get-count-new-recived-friendship-requests')
             ->assertStatus(200);
    }
}