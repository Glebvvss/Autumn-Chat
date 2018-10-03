<?php

namespace Tests\Feature\ServiceTests\Contacts\Friends\FriendshipRequestTests;

use Hash;
use Auth;
use Tests\TestCase;
use App\Eloquent\User;
use App\Eloquent\Friend;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquent\FriendshipRequest as FriendshipRequestTable;
use App\Services\Realizations\Contacts\Friends\FriendshipRequest;
use Tests\Feature\ServiceTests\Contacts\Friends\FriendshipRequestTests\Traits\TMockDataForTables;

class GetFriendshipRequestsTest extends TestCase
{
    use RefreshDatabase, TMockDataForTables;

    public function testGetSendedAll() {
        $this->userTableMock();

        $sender    = User::where('username', '=', 'testuser1')->first();
        $recipient = User::where('username', '=', 'testuser2')->first();

        $friendshipRequestTable = new FriendshipRequestTable();
        $friendshipRequestTable->sender_id = $sender->id;
        $friendshipRequestTable->recipient_id = $recipient->id;
        $friendshipRequestTable->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $friendshipRequests = $friendshipRequest->getSendedAll();

        $checkData = [
            [
                'id' => $friendshipRequestTable->id,
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'user_recipient' => [
                    'id' => $recipient->id,
                    'username' => $recipient->username,
                ]
            ]
        ];

        $this->assertEquals($checkData, $friendshipRequests);

        Auth::logout();
    }

    public function testGetRecivedAll() {
        $this->userTableMock();

        $sender    = User::where('username', '=', 'testuser1')->first();
        $recipient = User::where('username', '=', 'testuser2')->first();

        $friendshipRequestTable = new FriendshipRequestTable();
        $friendshipRequestTable->sender_id = $sender->id;
        $friendshipRequestTable->recipient_id = $recipient->id;
        $friendshipRequestTable->save();

        Auth::attempt([
            'username' => 'testuser2',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $friendshipRequests = $friendshipRequest->getRecivedAll();

        $checkData = [
            [
                'id' => $friendshipRequestTable->id,
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'user_sender' => [
                    'id' => $sender->id,
                    'username' => $sender->username,
                ]
            ]
        ];

        $this->assertEquals($checkData, $friendshipRequests);

        Auth::logout();
    }
}