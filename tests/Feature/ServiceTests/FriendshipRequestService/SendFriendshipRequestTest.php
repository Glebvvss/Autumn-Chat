<?php

namespace Tests\Feature\ServiceTests\FriendshipRequestService;

use Hash;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Friend;
use App\Models\FriendshipRequest;

use App\Services\Realizations\FriendshipRequestService;

use Tests\Feature\Mocks\Traits\TMockDataForTables;

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

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('testuser2');

        $this->assertEquals('Request has been sent.', $resultMessage);
        $this->assertTrue( $this->checkNewRequestInDatabase() );

        Auth::logout();
    }

    private function checkNewRequestInDatabase() : bool
    {
        $sender    = User::where('username', '=', 'testuser1')->first();
        $recipient = User::where('username', '=', 'testuser2')->first();

        $request = FriendshipRequest::where('sender_id', '=', $sender->id)
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

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('nonexcistentUser');

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

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('testuser1');

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

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('testuser2');

        $this->assertEquals('This user is already your friend.', $resultMessage);

        Auth::logout();
    }

    public function testSendAlreadySendedRequest()
    {
        $this->userTableMock();

        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = User::where('username', '=', 'testuser1')->first()->id;
        $friendshipRequest->recipient_id = User::where('username', '=', 'testuser2')->first()->id;
        $friendshipRequest->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('testuser2');

        $this->assertEquals('This request already has been sent.', $resultMessage);

        Auth::logout();
    }

    public function testSendToUserWhoAlreadySendRequestToYou()
    {
        $this->userTableMock();

        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id = User::where('username', '=', 'testuser2')->first()->id;
        $friendshipRequest->recipient_id = User::where('username', '=', 'testuser1')->first()->id;
        $friendshipRequest->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->sendTo('testuser2');

        $this->assertEquals('Already You have request from this user.', $resultMessage);

        Auth::logout();
    }

}
