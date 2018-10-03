<?php

namespace Tests\Feature\ServiceTests\Contacts\Friends\FriendshipRequestTests;

use Hash;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Eloquent\User;
use App\Eloquent\Friend;
use App\Eloquent\FriendshipRequest as FriendshipRequestTable;

use App\Services\Realizations\Contacts\Friends\FriendshipRequest;

use Tests\Feature\ServiceTests\Contacts\Friends\FriendshipRequestTests\Traits\TMockDataForTables;

class SendFriendshipRequestTest extends TestCase
{
    use RefreshDatabase, TMockDataForTables;

    public function testSendSuccessfully() 
    {
        $this->userTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('testuser2');

        $this->assertEquals('Request has been sent.', $resultMessage);
        $this->assertTrue( $this->checkNewRequestInDatabase() );

        Auth::logout();
    }

    private function checkNewRequestInDatabase() : bool
    {
        $sender    = User::where('username', '=', 'testuser1')->first();
        $recipient = User::where('username', '=', 'testuser2')->first();

        $request = FriendshipRequestTable::where('sender_id', '=', $sender->id)
            ->where('recipient_id', '=', $recipient->id)
            ->first();

        if ( $request ) {
            return true;
        }
        return false;
    }

    public function testSendToNonexistentUser() 
    {
        $this->userTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('nonexcistentUser');

        $this->assertEquals('This user is not exists.', $resultMessage);

        Auth::logout();
    }

    public function testSendToYourself() 
    {
        $this->userTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('testuser1');

        $this->assertEquals('You can`t send requests to yourself.', $resultMessage);

        Auth::logout();
    }

    public function testSendToAlreadyFriend() 
    {
        $this->userTableMock();
        $this->friendTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('testuser2');

        $this->assertEquals('This user is already your friend.', $resultMessage);

        Auth::logout();
    }

    public function testSendAlreadySendedRequest()
    {
        $this->userTableMock();

        $friendshipRequestTable = new FriendshipRequestTable();
        $friendshipRequestTable->sender_id = User::where('username', '=', 'testuser1')->first()->id;
        $friendshipRequestTable->recipient_id = User::where('username', '=', 'testuser2')->first()->id;
        $friendshipRequestTable->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('testuser2');

        $this->assertEquals('This request already has been sent.', $resultMessage);

        Auth::logout();
    }

    public function testSendToUserWhoAlreadySendRequestToYou()
    {
        $this->userTableMock();

        $friendshipRequestTable = new FriendshipRequestTable();
        $friendshipRequestTable->sender_id = User::where('username', '=', 'testuser2')->first()->id;
        $friendshipRequestTable->recipient_id = User::where('username', '=', 'testuser1')->first()->id;
        $friendshipRequestTable->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequest = new FriendshipRequest();
        $resultMessage = $friendshipRequest->sendTo('testuser2');

        $this->assertEquals('Already You have request from this user.', $resultMessage);

        Auth::logout();
    }

}
