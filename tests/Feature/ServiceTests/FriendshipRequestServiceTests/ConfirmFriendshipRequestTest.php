<?php

namespace Tests\Feature\ServiceTests\FriendshipRequestTests;

use Hash;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Friend;
use App\Models\FriendshipRequest;

use App\Services\Realizations\FriendshipRequestService;

use Tests\Feature\ServiceTests\FriendshipRequestServiceTests\Traits\TMockDataForTables;

class ConfirmFriendshipRequestTest extends TestCase
{
    use RefreshDatabase, TMockDataForTables;

    public function testConfirmFromInvalidSender() {
        $this->userTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->confirmFrom(999999);

        $this->assertEquals('Sender is not valid.', $resultMessage);

        Auth::logout();
    }

    public function testConfirmFromNonexistentRequest() {
        $this->userTableMock();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $senderId = User::where('username', '=', 'testuser2')->first()->id;

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->confirmFrom($senderId);

        $this->assertEquals('Request is not exists.', $resultMessage);

        Auth::logout();
    }

    public function testConfirmSuccess() {
        $this->userTableMock();

        $sender    = User::where('username', '=', 'testuser2')->first();
        $recipient = User::where('username', '=', 'testuser1')->first();

        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->sender_id    = $sender->id;
        $friendshipRequest->recipient_id = $recipient->id;
        $friendshipRequest->save();

        Auth::attempt([
            'username' => 'testuser1',
            'password' => 'password',
        ]);

        $senderId = User::where('username', '=', 'testuser2')->first()->id;

        $friendshipRequestService = new FriendshipRequestService();
        $resultMessage = $friendshipRequestService->confirmFrom($senderId);

        $this->assertEquals('Friend added!', $resultMessage);
        $this->assertTrue( $this->checkNewFriendRowsInDatabase($sender->id, $recipient->id) );
        
        Auth::logout();        
    }

    private function checkNewFriendRowsInDatabase( int $senderId, int $recipientId ) : bool
    {
        $friendRowForSender = Friend::where('user_id', '=', $senderId)
            ->where('friend_user_id', '=', $recipientId)
            ->first();

        $friendRowForRecipient = Friend::where('user_id', '=', $recipientId)
            ->where('friend_user_id', '=', $senderId)
            ->first();

        if ( $friendRowForSender && $friendRowForRecipient ) {
            return true;
        }
        return false;
    }

}